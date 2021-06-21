package test_project;

import java.util.List;
import java.util.Scanner;


/**
 * getType(input_string) return boolean;
 * findIndexes(수식기호,input_string) return arrayList
 * 
 * */

public class Runcalcul extends CalculList{
	
	//계산기 실행
	public static void run() {
		Scanner strInput = new Scanner(System.in);
		System.out.println("계산할 공식 입력후 = 를 입력해주세요.");
		
		while(true) {
			String strNumber = strInput.nextLine();
			if(getType(strNumber)) {
				if(strNumber.contains("=")) {
					List<Integer> findIndexes = findIndexes("+",strNumber);
					findIndexes.add(findEqIndexes("=",strNumber));
					
					//result
					System.out.println(resultNum(strNumber, "+", findIndexes));
					break;
				} else {
					System.out.println("= 을 입력해주세요.");
				}
			} else {
				System.out.println("숫자 및 사칙연산 부호만 입력해주세요");
			}
		}
	}
	
}
