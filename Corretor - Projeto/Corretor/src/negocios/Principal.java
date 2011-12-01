package negocios;

import java.io.BufferedOutputStream;
import java.io.BufferedReader;
import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.sql.Blob;
import java.sql.Connection;
import java.sql.SQLException;
import java.util.Collections;
import java.util.HashMap;
import java.util.HashSet;
import java.util.Vector;

import org.apache.commons.io.FileUtils;

import pegaCopias.PCopia;

import classesBasicas.CorretorRow;
import classesBasicas.MaterialCorrecao;
import classesBasicas.Submissao;

import repositorio.AcessoBanco;
import repositorio.GerenciadorConexao;

public class Principal {
	static Connection con;
	// Logins a serem corrigidos
	// Questoes a serem corrigidas
	static Vector<String> logins;
	static Vector<Integer> questoes;
	
	static HashMap<Integer, String> formatoArqQuestoes;
	static HashMap<Integer, Vector<MaterialCorrecao> > materialPorQuestao;
	
	
	public static void main(String[] args) {
		Runtime r = Runtime.getRuntime();
		Process p;
		Vector<Integer> pids = null;
		try {
			p = r.exec("ps ax");
			BufferedReader i = new BufferedReader( new InputStreamReader( p.getInputStream() ) );
			p.waitFor();
			String linha = null;
			pids = new Vector<Integer>();
			while( (linha = i.readLine()) != null ){
				if(linha.contains("Corretor.jar")){
					String pid = linha.trim().split(" ")[0];
					System.out.println(linha.trim() + " pid = " + linha.trim().split(" ")[0]);
					pids.add(Integer.parseInt(pid));
				}
			}
			
		} catch (IOException e) {
			e.printStackTrace();
		} catch (InterruptedException e) {
			e.printStackTrace();
		}
		Collections.sort(pids);
		if(args.length > 0 && ((String)args[0]).equals("stop-all") ){
			for(int i = 0; i < pids.size(); ++i){
				try {
					p = r.exec("kill " + pids.get(i));
					System.out.println("kill " + pids.get(i));
				} catch (IOException e) {
					e.printStackTrace();
				}
			}
		} else {
			for(int i = 0; i < pids.size()-1; ++i){
				try {
					p = r.exec("kill " + pids.get(i));
					System.out.println("kill " + pids.get(i));
				} catch (IOException e) {
					e.printStackTrace();
				}
			}
			loopPrincipal();
		}
		
	}
	
	public static void loopPrincipal(){
		
		while(true){
			
			try {
				CorretorRow cr = AcessoBanco.temCorrecao();
				if(cr != null){ // Existe uma correcao de lista a ser feita
					System.out.println("----- Inicio do Pedido de Correcao -----");
					System.out.println("Iniciar correcao de lista");
					
					FileUtils.cleanDirectory(new File(Constantes.pastaCorrecao));
					FileUtils.cleanDirectory(new File(Constantes.pastaMaterialCorrecao));
					FileUtils.cleanDirectory(new File(Constantes.pastaExecucao));
					realizarExtracaoMaterial(cr.id_corrigir);
					realizarExtracaoSubmissoes(cr.id_corrigir);
					CorrecaoLista cl = new CorrecaoLista(logins, questoes, formatoArqQuestoes, materialPorQuestao);
					Vector<int[][]> notas = cl.corrigirLista();
					
	//				String relatorioNotas = "------- Relatorio de Notas da Correcao da Lista " + cr.nome_lista +"  ------\n";
	//				System.out.println(relatorioNotas);
					for(int i = 0; i < notas.size(); ++i){
						System.out.println("Questao: " + questoes.get(i));
						for(int j = 0; j < notas.get(i).length; ++j){
							System.out.print(logins.get(j)+":");
							for(int k = 0; k < notas.get(i)[j].length; ++k){
								System.out.print(" " + notas.get(i)[j][k]);
							}
							System.out.println();
						}
					}
					
					
					System.out.println("Acabou Correcao da lista " + cr.id_corrigir);
					System.out.println("Iniciando envio das notas");
					Notas.enviarNotasCorrecaoLista(notas, questoes, logins, materialPorQuestao);
					System.out.println("Fim do envio das notas");
					// Chamar PegaCopias
					System.out.println("Inicio do pega copias");
					String relatorioPegaCopias = chamarPegaCopias();
					System.out.println("Fim do pega copias");
					System.out.println(relatorioPegaCopias);
					AcessoBanco.setarCorrecaoFeitaPegaCopias(cr.data_pedido, relatorioPegaCopias);
					System.out.println("Limpeza das pastas");
					FileUtils.cleanDirectory(new File(Constantes.pastaCorrecao));
					FileUtils.cleanDirectory(new File(Constantes.pastaMaterialCorrecao));
					FileUtils.cleanDirectory(new File(Constantes.pastaExecucao));
					System.out.println("----- Fim do Pedido de Correcao -----");
					
				}
				GerenciadorConexao.con.close();
			} catch (SQLException e) {
				e.printStackTrace();
			} catch (IOException e) {
				e.printStackTrace();
			} catch (InterruptedException e) {
				e.printStackTrace();
			}
			try{
				Thread.sleep(5000);
			} catch (InterruptedException e) {
				e.printStackTrace();
			}
		}
	}
	
	/**
	 * Este metodo vai pegar do banco de dados as submissoes que existem para a lista
	 * que sera corrigida, ele ira povoar o HashSet logins com os logins
	 * dos alunos que entregaram a lista.
	 * Ele tambem ira salvar os arquivos das submissoes, os codigos fonte dos alunos.
	 * @param id_lista
	 * @throws SQLException
	 */
	public static void realizarExtracaoSubmissoes(int id_lista) throws SQLException{
		Vector<Submissao> v = AcessoBanco.getArquivosSubmissoes(id_lista);
		HashSet<String> logins2 = new HashSet<String>();
		for(Submissao s : v){
			logins2.add(s.login);
			escreverBlobFile("./"+Constantes.pastaCorrecao+"/"+s.login+"/",formatoArqQuestoes.get(s.questao)+Constantes.getExtensao(s.linguagem),
					s.arquivo_fonte);
		//	System.out.println("aluno: " + s.login + "\nquestao: " + s.questao);
		}
		Vector<String> aux = AcessoBanco.getLoginsAlunos();
		logins2.addAll(aux);
		logins = new Vector<String>();
		logins.addAll(logins2);
	}
	
	/**
	 * Este metodo ira povoar o HashSet questoes com as questoes da lista a ser corrigida.
	 * Tambem ira pegar o material de correcao para estas questoes e salvar os arquivos.
	 * @param id_lista
	 * @throws SQLException 
	 */
	public static void realizarExtracaoMaterial(int id_lista) throws SQLException{
		Vector<MaterialCorrecao> v = AcessoBanco.getMaterialCorrecao(id_lista);
		
		questoes = new Vector<Integer>();
		formatoArqQuestoes = new HashMap<Integer, String>();
		materialPorQuestao = new HashMap<Integer, Vector<MaterialCorrecao>>();
		AcessoBanco.getFormatoQuestoes(id_lista, questoes, formatoArqQuestoes);
		for(int i = 0; i < questoes.size(); ++i){
			materialPorQuestao.put(questoes.get(i), new Vector<MaterialCorrecao>());
		}
		
		for(MaterialCorrecao m : v){
			escreverBlobFile(Constantes.pastaMaterialCorrecao+"/"+m.id_questao+"/", 
					formatoArqQuestoes.get(m.id_questao)+ "E" + m.id_correcao + ".in", m.entrada);
			escreverBlobFile(Constantes.pastaMaterialCorrecao+"/"+m.id_questao+"/", 
					formatoArqQuestoes.get(m.id_questao)+ "E" + m.id_correcao + ".out", m.saida);
			
			m.saida = null; m.entrada = null;
			materialPorQuestao.get(m.id_questao).add(m);
		}
		
	}
	
	public static void escreverBlobFile(String dir, String fileName, Blob arquivo){
		try {
			File f = new File(dir);
			f.mkdirs();
			f = new File(dir+fileName);
			BufferedOutputStream bos = new BufferedOutputStream(new FileOutputStream(f));
			bos.write(arquivo.getBytes(1, (int)arquivo.length() ), 0, (int)arquivo.length());
			bos.flush();
			bos.close();
		} catch (IOException e) {
			e.printStackTrace();
		} catch (SQLException e) {
			e.printStackTrace();
		}
	}
	
	/**
	 * Metodo auxiliar para chamar a classe PCopias com as informacoes de que
	 *  ela precisa (diretorios dos alunos e formato dos arquivos)
	 * @return
	 */
	public static String chamarPegaCopias(){
		File[] diretoriosAlunos = new File[logins.size()];
		for(int i = 0; i < logins.size(); ++i){
			diretoriosAlunos[i] = new File(Constantes.pastaCorrecao + "/" + logins.get(i));
		}
		String[] formatos = new String[questoes.size()];
		for(int i = 0; i < questoes.size(); ++i){
			formatos[i] = formatoArqQuestoes.get(questoes.get(i));
		}
		PCopia pc = new PCopia();
		return pc.pegaCopia(diretoriosAlunos, formatos);
	}
}
