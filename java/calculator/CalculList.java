package test_project;

import java.text.DecimalFormat;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Stack;

public class CalculList {
	private static HashMap<Character, Integer> opMap;

	public static void defindeOperation() {
		opMap = new HashMap<>();
		opMap.put('*', 3);
		opMap.put('/', 3);
		opMap.put('+', 2);
		opMap.put('-', 2);
	}

	public static boolean isProceed(char op1, char op2) {
		int op1Prec = opMap.get(op1);
		int op2Prec = opMap.get(op2);

		if(op1Prec >= op2Prec)
			return true;
		else
			return false;
	}

	public static boolean isNumeric(String str) {
		return str.matches("-?\\d+(\\.\\d+)?");
	}

	public static ArrayList<Object> infixToPostfix(String s) {
		ArrayList<Object> postFix = new ArrayList<>();
		String[] strs = s.split(" ");
		Stack<Character> stack = new Stack<>();

		for(int i = 0; i< strs.length; i++) {
			String str = strs[i];
			if(isNumeric(str)) {
				postFix.add(Integer.parseInt(str));
			} else {
				char ch = str.charAt(0);
				switch (ch) {
				case '+':
				case '-':
				case '/':
				case '*':
					while(!stack.isEmpty() && isProceed(stack.peek(), ch))
						postFix.add(stack.pop());
					stack.push(ch);
					break;
				}
			}
		}
		while(!stack.isEmpty())
			postFix.add(stack.pop());
		return postFix;
	}

	//수식 계산
	public static Float calculatePostfix(ArrayList<Object> postfix) {
		Stack<Float> stack = new Stack<>();

		for(int i = 0; i<postfix.size(); i++) {
			Object obj = postfix.get(i);
			if(obj instanceof Integer) {
				int num = (Integer)obj;
				stack.push((float) num);
			} else {
				Float b = stack.pop();
				Float a = stack.pop();
				char op = (char) obj;

				if(op =='+') {
					stack.push((a+b));
				}else if(op =='-') {
					stack.push((a-b));
				}else if(op =='*') {
					stack.push((a*b));
				}else if(op =='/') {
					stack.push((a/b));
				}
			}
		}

		return stack.pop();
	}

	//소숫점 0 버림
	public static String formatD(double number) {
		DecimalFormat df=new DecimalFormat("#.##");
		return df.format(number);
	}
}
