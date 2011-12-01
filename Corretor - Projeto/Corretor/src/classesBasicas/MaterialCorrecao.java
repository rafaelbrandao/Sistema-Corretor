package classesBasicas;

import java.sql.Blob;


/**
 * Imporante: apos a escrita dos arquivos de entrada e saida, os atributos saida e entrada ficarao NULL.
 * @author adrianalins
 *
 */
public class MaterialCorrecao {
	public int id_correcao, id_questao, peso, max_tempo;
	public Blob entrada, saida;
	
	
	public MaterialCorrecao(int id_correcao, int id_questao, Blob entrada, Blob saida, int peso, int max_tempo) {
		this.id_correcao = id_correcao;
		this.id_questao = id_questao;
		this.entrada = entrada;
		this.saida = saida;
		this.peso = peso;
		this.max_tempo = max_tempo;
	}
	
}
