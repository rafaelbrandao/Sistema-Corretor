package repositorio;

import java.sql.DriverManager;
import java.sql.SQLException;

import java.sql.Connection;

import negocios.Constantes;

public class GerenciadorConexao {
	public static Connection con = null;
	public static Connection getConnection() throws SQLException{
		try {
			if(con == null || con.isClosed()){
				long a = System.currentTimeMillis();
				Class.forName("com.mysql.jdbc.Driver");
				String url = "jdbc:mysql://"+ Constantes.URL_BD;
				con = DriverManager.getConnection(url, Constantes.USER_BD, Constantes.SENHA_BD);
				System.out.println("Pegou a conexao em " + (System.currentTimeMillis()-a));
			}
		} catch (ClassNotFoundException e) {
			e.printStackTrace();
		}
		return con;
	}
}
