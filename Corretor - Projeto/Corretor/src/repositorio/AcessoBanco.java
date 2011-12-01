package repositorio;

import java.sql.Blob;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.sql.Timestamp;
import java.util.HashMap;
import java.util.Vector;

import javax.sql.rowset.serial.SerialBlob;

import classesBasicas.CorretorRow;
import classesBasicas.MaterialCorrecao;
import classesBasicas.Submissao;

public class AcessoBanco {
	public static Vector<Submissao> getArquivosSubmissoes(int id_lista) throws SQLException{
		String consulta2 = "SELECT u.login as login, q.id_questao as questao, s.codigo_fonte as codigo_fonte, s.linguagem as linguagem" +
						" FROM Submissao s, Usuario u, Questao q WHERE s.login=u.login AND q.id_lista=" + id_lista +
						" AND s.id_questao=q.id_questao AND s.data_submissao IN (" + 
						" SELECT MAX(data_submissao) FROM Submissao ss WHERE ss.id_questao=q.id_questao AND ss.login=u.login )";
		Statement st = GerenciadorConexao.getConnection().createStatement();
		ResultSet rs = st.executeQuery(consulta2);
		
		Vector<Submissao> l = new Vector<Submissao>();
		while(rs.next()){
			l.add(  new Submissao( rs.getString("login"), rs.getString("linguagem"),
					rs.getInt("questao"), rs.getBlob("codigo_fonte") ) );
		}
		rs.close();
		st.close();
		return l;
	}
	
	public static Vector<MaterialCorrecao> getMaterialCorrecao(int id_lista) throws SQLException{
		String consulta = "SELECT m.id_correcao as id_correcao, q.id_questao as questao, m.entrada, m.saida as saida, " +
							"m.entrada as entrada, m.max_tempo_execucao as max_tempo, m.peso_correcao as peso" +
							" FROM  Material_Correcao m, Questao q WHERE q.id_questao = m.id_questao AND q.id_lista = " + id_lista;
		Statement st = GerenciadorConexao.getConnection().createStatement();
		ResultSet rs = st.executeQuery(consulta);
		Vector<MaterialCorrecao> v = new Vector<MaterialCorrecao>();
		while(rs.next()){
			v.add(new MaterialCorrecao(rs.getInt("id_correcao"), rs.getInt("questao"), rs.getBlob("entrada"),
					rs.getBlob("saida"), rs.getInt("peso"), rs.getInt("max_tempo")*1000));
		}
		
		st.close();
		rs.close();
		return v;
	}
	
	public static Vector<String> getLoginsAlunos() throws SQLException{
		String consulta = "SELECT login FROM Usuario WHERE tipo_permissao = 'aluno'";
		Statement st = GerenciadorConexao.getConnection().createStatement();
		ResultSet rs = st.executeQuery(consulta);
		Vector<String> v = new Vector<String>();
		while(rs.next()){
			v.add(rs.getString("login"));
		}
		st.close();
		rs.close();
		return v;
	}
	/**
	 * Esse metodo vai povoar o Vector e o HashMap passados como parametros com as informacoes extraidas do banco.
	 * @param id_lista
	 * @param questoesId
	 * @param formatoQuestoes
	 * @throws SQLException 
	 */
	public static void getFormatoQuestoes(int id_lista, Vector<Integer> questoesId, HashMap<Integer, String> formatoQuestoes) throws SQLException{
		String consulta = "SELECT l.nome_lista as nome_lista, q.numero as numero, q.id_questao as questao" +
				" FROM Questao q, Lista_Exercicios l WHERE l.id_lista = "+id_lista + " AND q.id_lista=l.id_lista";
		
		Statement st = GerenciadorConexao.getConnection().createStatement();
		ResultSet rs = st.executeQuery(consulta);
		
		while(rs.next()){
			questoesId.add(rs.getInt("questao"));
			formatoQuestoes.put(rs.getInt("questao"), rs.getString("nome_lista")+'Q'+rs.getInt("numero"));
		}
		
		st.close();
		rs.close();
	}
	
	public static CorretorRow temCorrecao() throws SQLException{
		
		String consulta = "SELECT l.id_lista as id_lista, l.nome_lista as nome_lista, data_pedido, estado FROM " +
				"Corretor c, Lista_Exercicios l WHERE l.id_lista=c.id_lista AND estado = 'Correcao' ORDER BY data_pedido ASC LIMIT 1;";
		
		Statement st = GerenciadorConexao.getConnection().createStatement();
		ResultSet rs = st.executeQuery(consulta);
		CorretorRow cor = null;
		if(rs.next()){
			cor = new CorretorRow(rs.getInt("id_lista"), rs.getTimestamp("data_pedido"), 
					rs.getString("estado"), rs.getString("nome_lista")); 
		}
		st.close();
		rs.close();
		return cor;
	}
	
	
	public static void setarCorrecaoFeitaPegaCopias(Timestamp pk, String relatorioPegaCopias) throws SQLException{
		String up = "UPDATE Corretor SET estado='Feito', relatorio_pcopia=? WHERE data_pedido=?";
		PreparedStatement ps = GerenciadorConexao.getConnection().prepareStatement(up);
		
		Blob b = new SerialBlob(relatorioPegaCopias.getBytes());
		ps.setBlob  (1, b);
		ps.setTimestamp(2, pk);
		ps.executeUpdate();
		ps.close();
	}
	
}
