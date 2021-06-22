import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;

public class Main {
    public static void main(String[] args) throws IOException {
    	BufferedReader br = new BufferedReader(new InputStreamReader(System.in));

    	int iflag = Integer.parseInt(br.readLine());

    	for(int i=0; i < iflag; i++) {

    		for(int j=0; j < i; j++) {
    			System.out.print(" ");
    		}

    		for(int j=1; j < 2*(iflag-i); j++) {
    			System.out.print("*");
    		}
    		System.out.println("");
    	}
    	br.close();
    }
}