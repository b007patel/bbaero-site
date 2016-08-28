package test;

import org.jsoup.*;
import org.jsoup.nodes.*;
import org.jsoup.parser.*;
import org.jsoup.select.*;
import java.util.*;
import java.io.*;

public class Test_tutils {

    public static void main(String args[]) {
        try {
            BufferedReader inf = new BufferedReader(
                    new FileReader("ex_rxn.html"));
            String exp_html = inf.readLine();
            String inp_html = inf.readLine();
            inf.close();
            Elements diff_res = 
                    TestUtils.findDifferentElements(exp_html, inp_html);
            Element first_e = diff_res.first();
            if (first_e.id().equals(TestUtils.MATCH_ID) && 
                    first_e.text().equals(TestUtils.MATCH_FOUND)) { 
                System.out.println("Input matches expected result\n");
                System.exit(0);
            }
            if (first_e.id().equals(TestUtils.BIGSIDE_ID)) {
                int ce = 0;
                boolean exp_bigger = first_e.text().equals(TestUtils.LBIGGER);
                if (exp_bigger) {
                    System.out.format("%s %s\n", "Expected result has",
                        "more elements than input!");
                } else {
                    System.out.format("%s %s\n", "Input has more elements",
                        "than expected result!");
                } 
                System.out.println("=============================");
                diff_res.remove(0);
                for (Element elem : diff_res) {
                    ce++;
                    System.out.format("Extra element %d:\n", ce);
                    System.out.format("\t%s\n", elem.toString());
                    System.out.format("has no equivalent\n\n");
                }
                System.exit(1);
            }
            if (diff_res != null && diff_res.size() > 0) {
                System.out.format("Expected element:\n");
                System.out.format(">> '%s'\n", diff_res.get(0).html());
                System.out.format("and input element:\n");
                System.out.format(">> '%s'\n", diff_res.get(1).html());
                System.out.format("do not match!!\n\n");
                /*System.out.format("expected element's parent:\n>> %s\n", 
                        diff_res.get(0).parent().html());
                System.out.format("input element's parent:\n>> %s\n", 
                        diff_res.get(1).parent().html());*/
                System.exit(1);
            }
            // should not happen
            System.out.println("Unknown condition! Exiting");
            System.exit(255);
        } catch (Throwable thr) {
            thr.printStackTrace();
            System.exit(255);
        }
    }
}
