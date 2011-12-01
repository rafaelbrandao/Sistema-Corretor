package negocios;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.HashMap;
import java.util.Vector;

import repositorio.GerenciadorConexao;

import classesBasicas.MaterialCorrecao;

public class Notas {
	
	/**
	 * Primeira dimensao do Vector eh a id_questao, mesmo indice vai valer para ambos
	 * Segunda dimensao do Vector eh por usuario
	 * Terceira dimensao eh o material de correcao
	 * @param notas
	 * @param id_questoes
	 * @param logins
	 * @param materialPorQuestao
	 */
	public static void enviarNotasCorrecaoLista(Vector<int[][]> notas, Vector<Integer> id_questoes,
			Vector<String> logins, HashMap<Integer, Vector<MaterialCorrecao> > materialPorQuestao ){
		Vector<MaterialCorrecao> materiais;
		int id_questao, aux[][];
		String login;
		for(int qi = 0; qi < notas.size(); ++qi){
			id_questao = id_questoes.get(qi);
			materiais = materialPorQuestao.get(id_questao);
			aux = notas.get(qi);
			for(int ui = 0; ui < aux.length; ++ui){
				login = logins.get(ui);
				enviarNotasPorMaterial(login, id_questao, materiais, aux[ui]);
			}	
		}
	}
	
	public static void enviarNotasPorMaterial(String login, int id_questao, 
			Vector<MaterialCorrecao> ids_materiais, int[] notas) {
		int id_correcao;
		
		for(int mi = 0; mi < ids_materiais.size(); ++mi){
			id_correcao = ids_materiais.get(mi).id_correcao;
			try{
			if(checarExistenciaNota(login, id_questao, id_correcao)){
				fazerUpdateNota(login, id_questao, id_correcao, notas[mi]);
			} else {
				fazerInsertNota(login, id_questao, id_correcao, notas[mi]);
			}
			} catch(SQLException sq) {
				System.out.println("Nao foi possivel complementar a insercao das notas no Banco de dados. Excecao: " 
						+ sq.getMessage());
			}
		}
	}
	
	public static void fazerUpdateNota(String login, int id_questao, int id_correcao, int nota) throws SQLException{
		String updatestr = String.format("UPDATE Nota_Lista SET valor_nota=%d WHERE login='%s' AND id_questao=%d AND id_correcao=%d"
				, nota, login, id_questao, id_correcao);
		Statement st = GerenciadorConexao.getConnection().createStatement();
		st.executeUpdate(updatestr);
		st.close();
	}
	
	public static void fazerInsertNota(String login, int id_questao, int id_correcao, int nota) throws SQLException{
		String insertstr = String.format("INSERT INTO Nota_Lista(login, id_questao, id_correcao, valor_nota) " +
				"values ('%s', %d, %d, %d)", login, id_questao, id_correcao, nota );
		Statement st = GerenciadorConexao.getConnection().createStatement();
		st.executeUpdate(insertstr);
		st.close();
	}
	
	public static boolean checarExistenciaNota(String login, int id_questao, int id_correcao) throws SQLException{
		String consulta = "SELECT valor_nota FROM Nota_Lista WHERE login = '" + 
				login + "' AND id_questao = " + id_questao + " AND id_correcao=" + id_correcao;
		Statement st = GerenciadorConexao.getConnection().createStatement();
		ResultSet rs = st.executeQuery(consulta);
		
		boolean ret = rs.next();
		st.close();
		rs.close();
		return ret;
	}
	
}
