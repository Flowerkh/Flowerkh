import java.util.ArrayList;
import java.util.Collections;
import java.util.HashSet;
import java.util.List;
import java.util.Set;

public class make_lotto_list {
	public static void main(String args[]) {
		
		for (int i =0; i<6; i++) {
			Set<Integer>set = new HashSet<>(); //중복 방지
			
			while (set.size() != 6) {
				set.add((int)(Math.random()*45+1));
			}
			
			//순서 정렬
			List<Integer> lotto_list = new ArrayList<>(set);
			Collections.sort(lotto_list);
			System.out.println((i+1)+"번째 > "+lotto_list);	
		}
	}
}
