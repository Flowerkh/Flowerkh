package test_project;

import java.util.ArrayList;
import java.util.List;
import java.util.regex.Pattern;

public class CalculList extends Caloperation{
	//수식 체크
		public static boolean getType(String word) {
			return Pattern.matches("^[0-9*\\/+\\-\\=]+$", word.trim());
		}
			
		//index 체크
		public static List<Integer> findIndexes(String word, String document){
			List<Integer> indexList = new ArrayList<Integer> ();
			int index = document.indexOf(word);
			
			while(index != -1) {
				indexList.add(index);
				index = document.indexOf(word,index+word.length());
			}
			return indexList;
		}
		
		//수식 계산
		public static long resultNum(String text, String type, List<Integer> arr_index) {
			int iflag = 0;
			long result = 0;

			for(int index:arr_index) {
				int i = Integer.parseInt(text.substring(iflag,index).replaceAll("[-|+|*|/]",""));
				iflag = index;
				switch(type) {
				case "+" :
					result = plus(result,i);
					break;
				case "-" :
					result = minus(result,i);
					break;
				case "*" :
					if(result==0) result = result+1;
					result = multiply(result,i);
					break;
				case "/" :
					if(result==0) result = i;
					result = divide(result,i);
					break;
				}
			}
			return result;
		}
		
		//= index 추출
		public static Integer findEqIndexes(String word, String document) {
			return document.indexOf(word);
		}
}
