package pegaCopias;
import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.Arrays;

/**
 * Classe destinada a ferrar os alunos vagabundos.
 * 
 * @author aca3
 */
public class PCopia {

	private int n, qtdCopias, minimo;
	private String nomes[];
	private int qtdLinhas[];
	private File arquivos[];
	private StringBuffer retorno;
	private Copia copias[];
	private Runtime r;
	private final int porcentagemMinimaPadrao = 25;
	
	/*Padrao esperado:
	  File[] files = new File[10];
	  files[0] = new File("./ArquivosCorrecao/alunos/alfl");
  	  files[1] = new File("./ArquivosCorrecao/alunos/aca3");*/
    
	/**Considera a porcentagem minima padrao de 35%
	 * 
	 * @param arquivos - Array de pastas terminando com o login do aluno e sem barra no fim
	 * @param formato - Array de strings representando os nomes das questoes (e dos arquivos)
	 * @return Uma string contendo o relatorio de copias
	 */
	public String pegaCopia(File arquivos[], String formato[]){
		return pegaCopia(arquivos, formato, porcentagemMinimaPadrao);
	}
	
	/**Temos que pegar todos.
	 * 
	 * @param arquivos - Array de pastas terminando com o login do aluno e sem barra no fim
	 * @param formato - Array de strings representando os nomes das questoes (e dos arquivos)
	 * @param porcentagemMinima - Valor entre 5 e 75% a ser considerado o minimo para categorizar uma copia
	 * @return Uma string contendo o relatorio de copias
	 */
	public String pegaCopia(File arquivos[], String formato[], int porcentagemMinima){
		r = Runtime.getRuntime();
		this.arquivos  = arquivos;
		n = arquivos.length;
		if(porcentagemMinima < 5) porcentagemMinima = 5;
		if(porcentagemMinima > 75) porcentagemMinima = 75;
		minimo = porcentagemMinima;
		if(n == 0) return "Lista de alunos vazia.\r";
		if(formato.length == 0) return "Quantidade nula de questoes.\r";
		nomes = new String[n+1];
		qtdLinhas = new int[n+1];
		retorno = new StringBuffer(n*formato.length*4);
		retorno.append("RELATORIO DE COPIAS:\r\r");
		copias = new Copia[(n*n-1)/2 +1];
		for(int i = 0; i < n; i++)
			nomes[i] = arquivos[i].getName();
		for(int i = 0; i < formato.length; i++){
			if(i > 0) retorno.append("\r\r");
			retorno.append("**** Questao " + formato[i] + " ****\r");
			rodar(formato[i]);
		}
		retorno.append("\rFIM DO RELATORIO\r");
		return retorno.toString();
	}
	
	private void rodar(String questao){
		String questaoJava = File.separatorChar+questao+".java";
		String questaoC = File.separatorChar+questao+".c";
		String questaoCpp = File.separatorChar+questao+".cpp";
		File temp;
		BufferedReader tempReader;
		for(int i = 0; i < n; ++i){
			temp = new File(arquivos[i].getPath() + questaoJava);
			if(!temp.exists()) temp = new File(arquivos[i].getPath() + questaoC);
			if(!temp.exists()) temp = new File(arquivos[i].getPath() + questaoCpp);
			if(!temp.exists()) continue;
			try {
				tempReader = new BufferedReader(new FileReader(temp));
				String linha;
				int tam = 0;
				while((linha = tempReader.readLine()) != null){
					//a linha nao eh apenas espaco+tabs (pois esses sao ignorados pelo diff)
					if(!linha.trim().isEmpty()) ++tam;
				}
				qtdLinhas[i] = tam;
			} catch (Exception e) {
				e.printStackTrace();
			}
		}
		qtdCopias = 0;
		for(int i = 0; i < n-1; ++i){
			for(int j = i+1; j < n; ++j){
				comparar(i, j, questaoJava);
				comparar(i, j, questaoC);
				comparar(i, j, questaoCpp);
			}
		}
		Arrays.sort(copias, 0, qtdCopias);
		for(int i = 0; i < qtdCopias; i++){
			retorno.append(nomes[copias[i].aluno1]); retorno.append(" e ");
			retorno.append(nomes[copias[i].aluno2]); retorno.append(": ");
			retorno.append(copias[i].porcentagemCopia/100);
			retorno.append('.');
			if(copias[i].porcentagemCopia%100 < 10) retorno.append('0');
			retorno.append(copias[i].porcentagemCopia%100);
			retorno.append("%\r");
		}
	}
	
	private void comparar(int um, int dois, String linguagem){
		File f1 = new File(arquivos[um].getPath()+linguagem);
		File f2 = new File(arquivos[dois].getPath()+linguagem);
		if(!f1.exists() || !f2.exists()) return;
		try{
			//testar com -Bbwi
			Process p = r.exec("diff -Bbwi " + f1.getAbsolutePath() + " " + f2.getAbsolutePath());
			
			InputStream ts = p.getInputStream();
	        BufferedReader reader = new BufferedReader(new InputStreamReader(ts));
	        String li;
	        int inserido = 0, deletado = 0;
	        while( ( li = reader.readLine()) != null){
	        	if (li.charAt(0) == '>') { //linha de codigo adicionada ou alterada
					inserido++;
				} else if (li.charAt(0) == '<') { //linha de codigo removida ou alterada
					deletado++;
				}
	        }
	        int menor = Math.min(qtdLinhas[um], qtdLinhas[dois]);
	        int cop = menor - Math.min(inserido, deletado); //a quantidade de linhas potencialmente copiadas
			double v = 0;
			if (cop > 0 && menor > 0) v = (100.0*cop)/(double)menor;
			if (v > minimo)	copias[qtdCopias++] = new Copia(um, dois, v);
		}
		catch(Exception e){
			//comentar a linha abaixo na versao final?
			e.printStackTrace();
		}
	}
	
	private class Copia implements Comparable<Copia>{
		int aluno1, aluno2, porcentagemCopia;
		
		public Copia(int a1, int a2, double valor){
			aluno1 = a1;
			aluno2 = a2;
			porcentagemCopia = (int)(valor*100);
		}
		@Override
		public int compareTo(Copia that) {
			if(porcentagemCopia < that.porcentagemCopia) return 1;
			else if(porcentagemCopia > that.porcentagemCopia) return -1;
			return 0;
		}
	}
	
	public static void main(String[] args) {
		int a = '\r';
		System.out.println(a);
	}
}
