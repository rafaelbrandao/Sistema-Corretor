package negocios;

import java.io.File;
import java.io.FileReader;
import java.util.Scanner;

public class Constantes {
	public static String USER_BD;
	public static String URL_BD;
	public static String SENHA_BD ;
	public static String pastaCorrecao;
	public static String pastaMaterialCorrecao;
	public static String pastaExecucao;
	public static String endClasseArquivo;
	
	static {
		try {
			FileReader cnf = new FileReader(new File("./configCorretor.cnf"));
			Scanner in = new Scanner(cnf);
			while(in.hasNext()){
				String campo = in.next();
				if(campo.equals("USER_BD")){
					USER_BD = readConfig(in.nextLine());
				} else if (campo.equals("URL_BD")){
					URL_BD = readConfig(in.nextLine());
				} else if (campo.equals("SENHA_BD")){
					SENHA_BD = readConfig(in.nextLine());
				} else if (campo.equals("pastaCorrecao")) {
					pastaCorrecao = readConfig(in.nextLine());
				} else if( campo.equals("pastaMaterialCorrecao")){
					pastaMaterialCorrecao = readConfig(in.nextLine());
				} else if( campo.equals("pastaExecucao")){
					pastaExecucao = readConfig(in.nextLine());
				} else if( campo.equals("endClasseArquivo")){
					endClasseArquivo = readConfig(in.nextLine());
				} else {
					in.nextLine();
				}
			}
			(new File(pastaCorrecao)).mkdirs();
			(new File(pastaMaterialCorrecao)).mkdirs();
			(new File(pastaExecucao)).mkdirs();
		} catch (Exception e) {
			System.out.println("Arquivo de configuracao nao se encontra na pasta do corretor. Sistema nao pode subir.");
			System.exit(-1);
		}
		
	}
	
	public static String readConfig(String linha){
		int ini = -1, fim = 0;
		for(int i = 0; i < linha.length(); ++i){
			if(linha.charAt(i) == '\"' ){
				if(ini == -1) ini = i+1;
				else {
					fim = i;
					break;
				}
			}
		}
		return linha.substring(ini, fim);
	}
	
	public static String getExtensao(String linguagem){
		if(linguagem.equalsIgnoreCase("java"))
			return ".java";
		else if(linguagem.equalsIgnoreCase("c++"))
			return ".cpp";
		else
			return ".c";
	}
}
