package negocios;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;

public class Compare {
	
	public static int pegarNota(File aluno, File gabarito ){
		try {
			BufferedReader bral = new BufferedReader(new FileReader(aluno));
			BufferedReader brgab = new BufferedReader(new FileReader(gabarito));
			String la = "", lg;
			int tot = 0, certas = 0;
			while( (lg = brgab.readLine()) != null){
				++tot;
				if(la == null || (la = bral.readLine()) == null) continue;
				if(la.equals(lg)) ++certas;
			}
			return (certas*1000)/tot;
			
		} catch (FileNotFoundException e) {
			return 0;
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return 0;
	}
	
	
}
