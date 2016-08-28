package test;

import org.jsoup.*;
import org.jsoup.nodes.*;
import org.jsoup.parser.*;
import org.jsoup.select.*;
import java.util.*;
import java.io.*;

public class TestParse {

    private static Element[] elemsdiff = {null, null};

    private static boolean findDiffElement(Element lbody, Element rbody) {
        Elements lelems = lbody.children();
        Elements relems = rbody.children();
        Elements extras = null;
        int lsize, rsize;

        lsize = lelems.size();
        rsize = relems.size();
        if (lsize == 0 && rsize == 0) {
            lelems = lbody.siblingElements();
            relems = rbody.siblingElements();
            lsize = lelems.size();
            rsize = relems.size();
            if (lsize == 0 && rsize == 0) {
                return false; // end recursion
            }
        }
        if (lsize > rsize) {
            System.out.println("Target has more elements than input!");
            extras = new Elements(lelems.subList(rsize, lsize - 1));
        } else if (lsize < rsize) {
            System.out.println("Input has more elements than target!");
            extras = new Elements(relems.subList(lsize, rsize - 1));
        }
        if (extras != null && extras.size() > 0) {
            int ce = 0;
            for (Element elem : extras) {
                ce++;
                System.out.format("Extra element %d:\n", ce);
                System.out.format("\t%s\n", elem.toString());
                System.out.format("has no equivalent\n\n");
            }
            return true;
        }
        
        // Elements have same number of descendants. Find the first
        // mismatch
        boolean elems_match = true;
        int ce = 0;
        Element cur_l = null;
        Element cur_r = null;

        while (ce < lsize && elems_match) {
            cur_l = lelems.get(ce);
            cur_r = relems.get(ce);
            elems_match = cur_l.html().equals(cur_r.html());
            ce++;
        }
        if (!findDiffElement(cur_l, cur_r)) {
            if (!cur_l.html().equals(cur_r.html())) {
                elemsdiff[0] = cur_l;
                elemsdiff[1] = cur_r;
                return true;
            }
        }
        return false;
    }

    public static void main(String args[]) {
        try {
            BufferedReader inf = new BufferedReader(
                    new FileReader("ex_rxn.html"));
            String rawtgthtml = inf.readLine();
            String rawinphtml = inf.readLine();
            inf.close();
            Document tgtdoc = Jsoup.parseBodyFragment(rawtgthtml); 
            Document inpdoc = Jsoup.parseBodyFragment(rawinphtml); 
            String tgthtml = tgtdoc.toString();
            String inphtml = inpdoc.toString();
            if (tgthtml.equals(inphtml)) {
                System.out.println("Target matches input");
            } else {
                findDiffElement(tgtdoc.body(), inpdoc.body());
                System.out.format("Target element:\n");
                System.out.format(">> '%s'\n", elemsdiff[0].html());
                System.out.format("and input element:\n");
                System.out.format(">> '%s'\n", elemsdiff[1].html());
                System.out.format("do not match!!\n\n");
                /*System.out.format("target parent:\n>> %s\n", 
                        elemsdiff[0].parent().html());
                System.out.format("input parent:\n>> %s\n", 
                        elemsdiff[1].parent().html());*/
            }
        } catch (Throwable thr) {
            thr.printStackTrace();
        }
    }
}
