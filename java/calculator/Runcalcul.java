package test_project;

import java.util.ArrayList;
import java.util.Scanner;

public class Runcalcul extends CalculList{
	
	//계산기 실행
	public static void run() {
		System.out.println("계산할 공식 입력해주세요.");
		Scanner scanner = new Scanner(System.in);
		
		defindeOperation();
		
		String input = scanner.nextLine();
		
		String result;
		result = input.replace("*", " * ");
		result = result.replace("/", " / ");
		result = result.replace("-", " - ");
		result = result.replace("+", " + ");
		
		ArrayList<Object> post = infixToPostfix(result);
		System.out.println(formatD(calculatePostfix(post)));
		//System.out.println(post.toString());
	}
		
}
