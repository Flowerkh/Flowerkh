import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.io.IOException;

public class Main {

	public static void main(String[] args) throws IOException {
		BufferedReader br = new BufferedReader(new InputStreamReader(System.in));
		int[] arr = new int[9];

		for(int i=0; i<9; i++) {
			arr[i] = Integer.parseInt(br.readLine());
		}

		int max = 0;
		int idx = 0;
		int cnt = 0;

		for(int val : arr) {
			cnt++;
			if(val > max) {
				max = val;
				idx = cnt;
			}
		}
		System.out.println(max);
		System.out.println(idx);
	}
}