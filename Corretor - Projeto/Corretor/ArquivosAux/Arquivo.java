/*
 * Universidade Federal de Pernambuco
 * Centro de Informática
 * Disciplina: Algoritmos e Estrutura de Dados
 *
 */
import java.io.*;

/**
 * Classe que manipula a entrada e saída de dados de um programa através de
 * arquivos.<br> <br>
 *
 * Exemplo de Uso: <br> <br> <code>
 *
 * // Abre os arquivos de entrada e saída <br>
 * Arquivo io = new Arquivo("L1Q1.in", "L1Q1.out"); <br> <br>
 *
 * // Lê dados do arquivo de entrada <br>
 * String s = io.readString(); <br>
 * char c = io.readChar(); <br>
 * int i = io.readInt(); <br>
 * double d = io.readDouble(); <br> <br>
 *
 * // Grava dados no arquivo de saída <br>
 * io.print("Algoritmos"); <br>
 * io.print(35); <br>
 * io.println(2.3); <br> <br>
 *
 * // Fecha o arquivo após o uso <br>
 * io.close(); <br> </code>
 *
 * @author   Emannuel Macêdo (egm@cin.ufpe.br)
 *
 */

public class Arquivo {

    private BufferedReader in;
    private PrintWriter out;
    private String[] buffer;
    private int nextChar;
    private int nextTokenLin, nextTokenCol;
    private int primLin, contLin;

   /**
    * Construtor da classe Arquivo. Abre o arquivo de entrada no modo leitura,
    * e o arquivo de saída no modo gravação. Se o arquivo de saída já existir,
    * seu conteúdo é descartado.
    *
    * @param in     nome do arquivo de entrada de dados
    * @param out    nome do arquivo de saída de dados
    *
    */
    public Arquivo(String in, String out) {
        try {
            // abre o arquivo de entrada no modo leitura
            this.in = new BufferedReader(new FileReader(in));

            // abre o arquivo de saída no modo gravação
            this.out = new PrintWriter(new FileWriter(out), true);

            this.initBuffer();

        } catch (IOException e) {
            throw new RuntimeException(e.toString());
        }
    }

   /** Fecha o arquivo quando o garbage collector é chamado */
    protected void finalize() {
        this.close();
    }

   /** Fecha o arquivo, após o seu uso. */
    public void close() {
        try {
            if (this.in != null) {
                this.in.close();
                this.in = null;
            }

            if (this.out != null) {
                this.out.close();
                this.out = null;
            }
        } catch (IOException e) {
            throw new RuntimeException(e.toString());
        }
    }

    /* -------------------------------------------- */
    /* ------------ FUNÇÕES DE LEITURA ------------ */
    /* -------------------------------------------- */

    /** Indica se foi encontrado o fim do arquivo. */
    public boolean isEndOfFile() {
        return (this.nextTokenLin < 0);
    }

    /** Indica se foi encontrado o fim da linha. */
    public boolean isEndOfLine() {
        return (this.nextTokenLin != this.primLin);
    }

   /**
    * Lê uma linha do arquivo. Se parte da linha já foi lida, então o restante
    * é retornado, mesmo que seja uma linha em branco (String de tamanho zero).
    *
    * @return   a próxima linha lida do arquivo, ou <code>null</code> se o fim
    *           do arquivo for encontrado
    *
    */
    public String readLine() {
        if (this.contLin <= 0)
            return null;

        String line = this.buffer[this.primLin];
        if (this.nextChar > 0)
            if (this.nextChar >= line.length())
                line = "";
            else
                line = line.substring(this.nextChar, line.length()-1);

        this.buffer[this.primLin] = null;
        this.nextChar = 0;
        this.primLin++;
        this.contLin--;

        if (this.nextTokenLin >= 0 && this.nextTokenLin < this.primLin)
            this.findNext();

        return line;
    }

   /**
    * Lê o próximo caractere do arquivo, incluindo espaços (' ') e quebras de
    * linha ('\n'). Se o fim do arquivo for alcançado, o caractere nulo ('\0')
    * é retornado.
    *
    * @return   o caractere lido
    */
    public char readChar() {
        if (this.contLin <= 0)
            return '\0';

        char newChar;
        String line = this.buffer[this.primLin];
        if (this.nextChar >= line.length()) {
            newChar = '\n';
            this.readLine();
        } else {
            newChar = line.charAt(this.nextChar++);
            if (newChar != ' ' && this.nextTokenLin >= 0)
                this.findNext();
        }

        return newChar;
    }

   /**
    * Lê uma string do arquivo.
    *
    * @return   a string lida
    *
    */
    public String readString() {
        String next = null;

        try {
            this.checkEOF();

            String line = this.buffer[this.nextTokenLin];
            for (int i = this.primLin; i < this.contLin; i++)
                this.buffer[i] = null;
            this.buffer[0] = line;
            this.nextTokenLin = this.primLin = 0;
            this.contLin = 1;

            int i, size = line.length();
            for (i = this.nextTokenCol; i < size; i++)
                if (line.charAt(i) == ' ')
                    break;

            next = line.substring(this.nextTokenCol, i);
            this.nextChar = i;
            this.findNext();
        } catch (IOException e) {
            throw new RuntimeException(e.toString());
        }

        return next;
    }

   /**
    * Lê um inteiro do arquivo.
    *
    * @return   o número lido
    *
    */
    public int readInt() {
        return Integer.valueOf(this.readString()).intValue();
    }

   /**
    * Lê um double do arquivo.
    *
    * @return   o número lido
    *
    */
    public double readDouble() {
        return Double.valueOf(this.readString()).doubleValue();
    }

    /* -------------------------------------------- */
    /* ------ FUNÇÕES AUXILIARES DE LEITURA ------- */
    /* -------------------------------------------- */

    /** Prepara o buffer de entrada para ser usado */
    private void initBuffer() throws IOException {
        this.buffer = new String[5];
        this.nextChar = 0;
        this.nextTokenLin = 0;
        this.primLin = this.contLin = 0;

        String line = this.in.readLine();
        if (line == null) {
            this.nextTokenLin = -1;
        } else {
            this.buffer[0] = line;
            this.contLin++;
            this.findNext();
        }
    }

    /** Verifica se o fim do arquivo foi encontrado */
    private void checkEOF() throws EOFException {
        if (this.isEndOfFile())
            throw new EOFException();
    }

    /** Acrescenta uma linha lida do arquivo no buffer */
    private int appendLine(String str) {
        if (this.contLin == 0)
            this.primLin = 0;

        if (this.primLin + this.contLin >= this.buffer.length) {
            String[] src = this.buffer;
            if (this.contLin >= this.buffer.length)
                this.buffer = new String[2 * this.buffer.length];

            System.arraycopy(src, this.primLin, this.buffer, 0, this.contLin);
            this.nextTokenLin -= this.primLin;
            this.primLin = 0;
        }

        buffer[this.primLin + this.contLin] = str;
        this.contLin++;
        return (this.primLin + this.contLin - 1);
    }

    /** Encontra a posição do próximo token a ser lido */
    private void findNext() {
        try {
            String line = this.buffer[this.primLin];
            if (line != null) {
                int size = line.length();
                for (int i = this.nextChar; i < size; i++)
                    if (line.charAt(i) != ' ') {
                        this.nextTokenCol = i;
                        return;
                    }
            }

            this.nextTokenLin = this.nextTokenCol = -1;
            while ((line = this.in.readLine()) != null) {
                int size = line.length();
                for (int i = 0; i < size; i++)
                    if (line.charAt(i) != ' ') {
                        this.nextTokenCol = i;
                        this.nextTokenLin = this.appendLine(line);
                        return;
                    }
                this.appendLine(line);
            }
        } catch (IOException e) {
            throw new RuntimeException(e.toString());
        }
    }

    /* -------------------------------------------- */
    /* ------------ FUNÇÕES DE ESCRITA ------------ */
    /* -------------------------------------------- */

   /**
    * Escreve um caractere no arquivo.
    *
    * @param c     caractere que será escrito no arquivo
    *
    */
    public void print(char c) {
        this.out.print(String.valueOf(c));
    }

   /**
    * Escreve uma string no arquivo.
    *
    * @param s     string que será escrita no arquivo
    *
    */
    public void print(String s) {
        this.out.print(s);
    }

   /**
    * Escreve um inteiro no arquivo.
    *
    * @param i     número que será escrito no arquivo
    *
    */
    public void print(int i) {
        this.out.print(i);
    }

   /**
    * Escreve um double no arquivo.
    *
    * @param d     número que será escrito no arquivo
    * @exception IOException   em caso de erro de I/O
    *
    */
    public void print(double d) {
        this.out.print(d);
    }

   /**
    * Escreve um double no arquivo, com um número fixo de casas decimais. Uma
    * precisão menor ou igual a zero indica que apenas a parte inteira será
    * impressa (com arredondamento).
    *
    * @param d     número que será escrito no arquivo
    * @param dec   número de casas decimais de precisao
    * @exception IOException   em caso de erro de I/O
    *
    */
    public void print(double d, int dec) {
        this.out.print(this.formatDouble(d, dec));
    }

   /**
    * Começa uma nova linha no arquivo.
    *
    */
    public void println() {
        this.out.println();
    }

   /**
    * Escreve um caractere e começa uma nova linha no arquivo.
    *
    * @param c     caractere que será escrito no arquivo
    *
    */
    public void println(char c) {
        this.out.println(String.valueOf(c));
    }

   /**
    * Escreve uma string e começa uma nova linha no arquivo.
    *
    * @param s        string que será gravada no arquivo
    *
    */
    public void println(String s) {
        this.out.println(s);
    }
	
   /**
    * Escreve uma array de char e começa uma nova linha no arquivo.
    *
    * @param s        array de char que será gravada no arquivo
    *
    */
    public void println(char[] x) {
        this.out.println(x);
    }

   /**
    * Escreve um inteiro e começa uma nova linha no arquivo.
    *
    * @param i        número que será gravado no arquivo
    *
    */
    public void println(int i) {
        this.out.println(i);
    }

   /**
    * Escreve um double e começa uma nova linha no arquivo.
    *
    * @param d        número que será gravado no arquivo
    * @exception IOException   em caso de erro de I/O
    *
    */
    public void println(double d) {
        this.out.println(d);
    }

   /**
    * Escreve um double no arquivo, com um número fixo de casas decimais e
    * começa uma nova linha no arquivo. Uma precisão menor ou igual a zero
    * indica que apenas a parte inteira será impressa (com arredondamento).
    *
    * @param d     número que será escrito no arquivo
    * @param dec   número de casas decimais de precisao
    * @exception IOException   em caso de erro de I/O
    *
    */
    public void println(double d, int dec) {
        this.out.println(this.formatDouble(d, dec));
    }

   /**
    * Grava os dados do buffer no arquivo. Isto é feito automaticamente a cada
    * quebra de linha (<code>println</code>).
    */
    public void flush() {
        this.out.flush();
    }

    /* -------------------------------------------- */
    /* ------ FUNÇÕES AUXILIARES DE ESCRITA ------- */
    /* -------------------------------------------- */

	private String formatDouble(double d, int dec) {
        if (dec <= 0) {
            return String.valueOf(Math.round(d));
        }
        StringBuffer res = new StringBuffer();
        long aprox = (int) Math.round(d * Math.pow(10, dec));
        if (d < 0) {
            aprox = -aprox;
            res.append('-');
        }
        String num = String.valueOf(aprox);
        int n = num.length() - dec;
        if (n <= 0) {
            res.append("0.");
            for (int i = 0; i < -n; i++)
                res.append('0');
            res.append(num);
        } else {
            char[] array = num.toCharArray();
            res.append(array, 0, n).append('.').append(array, n, dec);
        }
        return res.toString();
    }

}
