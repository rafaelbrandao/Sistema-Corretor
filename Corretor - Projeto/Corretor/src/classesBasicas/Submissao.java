package classesBasicas;

import java.sql.Blob;

public class Submissao {
	public String login;
	public String linguagem;
	public int questao;
	public Blob arquivo_fonte;
	public Submissao(String login, String linguagem, int questao, Blob arquivo_fonte) {
		this.login = login;
		this.linguagem = linguagem;
		this.questao = questao;
		this.arquivo_fonte = arquivo_fonte;
	}
}
