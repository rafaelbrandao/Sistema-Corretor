package negocios;

import java.io.File;
import java.io.IOException;
import java.util.HashMap;
import java.util.Vector;
import java.util.regex.Pattern;

import org.apache.commons.io.FileUtils;

import classesBasicas.MaterialCorrecao;

public class CorrecaoLista {

	Vector<String> logins;
	Vector<Integer> questoes;
	HashMap<Integer, String> formatoArqQuestoes;
	HashMap<Integer, Vector<MaterialCorrecao>> materialPorQuestao;
	Runtime r;
	
	public CorrecaoLista(Vector<String> logins, Vector<Integer> questoes, HashMap<Integer, String> formatoArqQuestoes,
			HashMap<Integer, Vector<MaterialCorrecao>> materialPorQuestao){
		this.logins = logins;
		this.questoes = questoes;
		this.formatoArqQuestoes = formatoArqQuestoes;
		this.materialPorQuestao = materialPorQuestao;
		r = Runtime.getRuntime();
	}
	
	public Vector< int[][] > corrigirLista() throws IOException, InterruptedException{

		try {
			Process p = r.exec("javac " + Constantes.endClasseArquivo + "/Arquivo.java" );
			p.waitFor();
		} catch (IOException e) {
			e.printStackTrace();
		} catch (InterruptedException e) {
			e.printStackTrace();
		}
		Vector< int[][] > saida = new Vector< int[][] >();
		for(int i = 0; i < questoes.size(); ++i){
			saida.add(corrigirQuestao(questoes.get(i))) ;
			
		}
		FileUtils.deleteQuietly(new File(Constantes.endClasseArquivo + "/Arquivo.class"));
		return saida;
	}
	
	/**
	 * Dada uma questao, o metodo ira varrer todos os alunos para corrigir esta questao usando seus materiais de correcao
	 * @param idquestao
	 * @return A primeira dimensao eh determinada pelo numero de alunos, a segunda pelo numero de materiais de correcao para aquela questao
	 * @throws IOException
	 * @throws InterruptedException
	 */
	public int[][] corrigirQuestao(int idquestao) throws IOException, InterruptedException{
		Vector<MaterialCorrecao> idmateriais = materialPorQuestao.get(idquestao);
		System.out.println("Corrigindo Questao " + formatoArqQuestoes.get(idquestao));
		int[][] notas = new int[logins.size()][idmateriais.size()];
		
		// Aqui sao feitos Files com os enderecos dos arquivos de entrada 
		// e saida para facilitar o processo de copiar e comparar resultados
		File entradas[] = new File[idmateriais.size()];
		File saidas[] = new File[idmateriais.size()];
		for(int i = 0; i < idmateriais.size(); ++i){
			entradas[i] = new File(Constantes.pastaMaterialCorrecao+ "/"+ idquestao +"/" +formatoArqQuestoes.get(idquestao)+
					"E"+idmateriais.get(i).id_correcao+".in");
			saidas[i] = new File(Constantes.pastaMaterialCorrecao+ "/"+ idquestao + "/" + formatoArqQuestoes.get(idquestao)+
					"E"+idmateriais.get(i).id_correcao+".out");
		}
		File entradaDest = new File( Constantes.pastaExecucao + "/" + formatoArqQuestoes.get(idquestao) + ".in"  );
		File saidaAluno = new File( Constantes.pastaExecucao + "/" + formatoArqQuestoes.get(idquestao) + ".out"  );
		// fim da criacao dos File auxiliares
		
		File f;
		int ling;
		// Para cada questao que eh passada como parametro, existe um formato para os arquivos,
		// entao vamos procurar nas pastas dos alunos estes arquivos.
		Pattern p = Pattern.compile(formatoArqQuestoes.get(idquestao)+ ".*");
		for(int i = 0; i < logins.size(); ++i){
			f = new File(Constantes.pastaCorrecao + "/" + logins.get(i)+ "/");
			if(f.exists()){
				String[] arqNaPasta = f.list();
				int a = 0;
				boolean achou = false;
				// Procura o arquivo fonte para a questao a ser corrigida
				for(a = 0; a < arqNaPasta.length; ++a){
					if( p.matcher( arqNaPasta[a] ).matches() ){
						achou = true;
						break;
					}
				}
				// se achou o arquivo, vai comear o processo de correcao
				if( achou ){

					f = new File(Constantes.pastaCorrecao + "/" + logins.get(i)+ "/"+arqNaPasta[a]);
					File dest = new File(Constantes.pastaExecucao + "/" + arqNaPasta[a]);
					FileUtils.copyFile(f, dest);
					try{
					if(arqNaPasta[a].charAt(arqNaPasta[a].length()-1) == 'c'){ // Compila em C
						ling = 1;
						Process po = r.exec("gcc -o main -Wall -lm " + arqNaPasta[a], null, new File(Constantes.pastaExecucao ));
						po.waitFor();
					} else if (arqNaPasta[a].charAt(arqNaPasta[a].length()-1) == 'p'){ // Compila em C++
						ling = 2;
						Process po = r.exec("g++ -o main -Wall -lm " + arqNaPasta[a], null, new File(Constantes.pastaExecucao ));
						po.waitFor();
					} else { // Compila Java, nesse caso a classe Arquivo tambem o copiada para a pasta de execucao
						ling = 3;
						FileUtils.copyFile(new File(Constantes.endClasseArquivo + "/Arquivo.class"), new File( Constantes.pastaExecucao + "/Arquivo.class"));
						Process po = r.exec("javac " + arqNaPasta[a], null, new File(Constantes.pastaExecucao) );
						po.waitFor();
					}

					for(int j = 0; j < idmateriais.size(); ++j){
						FileUtils.copyFile(entradas[j], entradaDest);
						if(executarCodigoAluno(arqNaPasta[a], ling, idmateriais.get(j).max_tempo) == -1){
							// erro de compilacao no codigo do cara
							// vamos ver se isso ainda vai ser tratado
						} else {
							notas[i][j] = Compare.pegarNota(saidaAluno, saidas[j]);
						}

						FileUtils.deleteQuietly(saidaAluno);
					}
					FileUtils.cleanDirectory(new File(Constantes.pastaExecucao));
					} catch (Exception e) {
						// todas as excecoes nessa area sao de responsabilidade do aluno
						System.out.println("Houve uma excecao na area de compilacao e execucao do codigo do aluno: "
								+ e.getMessage() + "Causada por: " + e.getMessage());
			
					}
				}
			}
		}
		return notas;
	}
	
	/**
	 * ling 1 = C
	 * ling 2 = C++
	 * ling 3 = Java
	 * @param nomeCodigo Aqui eh a String do nome do codigo, ou seja "LXQY.java" ou .cpp, ou .c, sem mais nada do nome do arquivo.
	 * @param ling Representa o codigo da linguagem em que o codigo esta, os codigos estao acima.
	 * 
	 * @throws IOException 
	 * @throws InterruptedException 
	 */
	public int executarCodigoAluno(String nomeCodigo, int ling, int tempoLimite) throws IOException, InterruptedException{
		if(ling == 1 || ling == 2){
			try{
				Process p = r.exec("./main", null, new File(Constantes.pastaExecucao));
				esperarProcess(p, tempoLimite);
			} catch (IOException io) {
				// o aluno pode ter lavado erro de compilacao e o arquivo nao estar‡ la, isso da excecao.
			}
		} else {
			Process p = r.exec("java " + nomeCodigo.substring(0, nomeCodigo.length()-5), null, new File(Constantes.pastaExecucao));
			esperarProcess(p, tempoLimite);
			
		}
		return 0;
	}
	
	/**
	 * Apos o tempo tempo limite, o processo ser‡ destruido.
	 * @param p Subprocess que est‡ rodando e que deve ser aguardado
	 * @param tl Tempo limite para o processo rodar
	 */
	public void esperarProcess(Process p, int tl){
		while( tl > 0 ){
			try {
				Thread.sleep(Math.min(300, tl));
				tl -= 300;
				p.exitValue();
			} catch (InterruptedException e) {
				continue;
			} catch (IllegalThreadStateException ill){
				continue;
			}
			break;
		}
		p.destroy();
		
	}

}
