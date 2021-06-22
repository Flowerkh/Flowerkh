import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;

public class Main {
    public static void main(String[] args) throws IOException {
    	BufferedReader br = new BufferedReader(new InputStreamReader(System.in));

    	int iflag = Integer.parseInt(br.readLine());

    	//위
    	for(int i=1; i <= iflag; i++) {

    		for(int j=1; j <= i; j++) {
    			System.out.print("*");
    		}
    		for(int j=1; j <= (iflag-i)*2; j++) {
    			System.out.print(" ");
    		}
    		for(int j=1; j <= i; j++) {
    			System.out.print("*");
    		}
    		System.out.println("");

    	}
    	//아래
    	for(int i=1; i <= iflag-1; i++) {

    		for(int j=1; j <= iflag-i; j++) {
    			System.out.print("*");
    		}
    		for(int j=1; j <= i*2; j++) {
    			System.out.print(" ");
    		}
    		for(int j=1; j <= iflag-i; j++) {
    			System.out.print("*");
    		}
    		System.out.println("");

    	}
    	br.close();
    }
}