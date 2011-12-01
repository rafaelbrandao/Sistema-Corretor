package classesBasicas;

import java.sql.Timestamp;

public class CorretorRow {
	public int id_corrigir, id_corretor;
	public Timestamp data_pedido;
	public String estado, nome_lista;
	
	public CorretorRow(int id_corrigir, Timestamp data_pedido, String estado, String nome_lista) {
		this.id_corrigir = id_corrigir;
		this.data_pedido = data_pedido;
		this.estado = estado;
	}
	
}
