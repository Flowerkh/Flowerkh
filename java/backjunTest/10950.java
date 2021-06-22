import java.util.*;

public interface Main{
    static void main(String[]x){
        Scanner sc = new Scanner(System.in);
        int n=sc.nextInt();
         for(int i=0;i<n;i++){
          int a=sc.nextInt()+sc.nextInt();
          System.out.println( a );
        }
    }
}