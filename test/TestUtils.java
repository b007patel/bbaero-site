package test;

import org.jsoup.*;
import org.jsoup.nodes.*;
import org.jsoup.parser.Tag;
import org.jsoup.select.*;

public class TestUtils {

    private static Elements elemsdiff = null;
    
    public static final String MATCH_ID = "doesMatch";
    public static final String MATCH_FOUND = "matches";
    public static final String BIGSIDE_ID = "largerside";
    public static final String LBIGGER = "left";
    public static final String RBIGGER = "right";

    private static boolean inspectElementsForDiff(Element lbody, Element rbody) {
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
        Attributes flag_id = new Attributes();
        Element lg_elem = null;
        flag_id.put("id", BIGSIDE_ID);
        lg_elem = new Element(Tag.valueOf("span"), "", flag_id);
        if (lsize > rsize) {
            extras = new Elements(lelems.subList(rsize, lsize));
            lg_elem.text(LBIGGER);
            extras.add(0, lg_elem);
        } else if (lsize < rsize) {
            extras = new Elements(relems.subList(lsize, rsize));
            lg_elem.text(RBIGGER);
            extras.add(0, lg_elem);
        }
        if (extras != null && extras.size() > 0) {
            elemsdiff = extras; 
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
        if (!inspectElementsForDiff(cur_l, cur_r)) {
            if (!cur_l.html().equals(cur_r.html())) {
                if (elemsdiff == null) elemsdiff = new Elements();
                if (elemsdiff.size() > 0) elemsdiff.remove();
                elemsdiff.add(cur_l);
                elemsdiff.add(cur_r);
                return true;
            }
        }
        return false;
    }

    public static Elements findDifferentElements(String raw_ex, String raw_in) {
        try {
            if (elemsdiff != null && elemsdiff.size() > 0) elemsdiff.remove();
            Document expdoc = Jsoup.parseBodyFragment(raw_ex); 
            Document inpdoc = Jsoup.parseBodyFragment(raw_in); 
            String exp_html = expdoc.toString();
            String inp_html = inpdoc.toString();
            if (exp_html.equals(inp_html)) {
                Attributes match_flag_id = new Attributes();
                match_flag_id.put("id", MATCH_ID);
                elemsdiff.add(new Element(Tag.valueOf("span"), MATCH_FOUND, 
                        match_flag_id));
            } else {
                inspectElementsForDiff(expdoc.body(), inpdoc.body());
            }
        } catch (Throwable thr) {
            thr.printStackTrace();
        }
        return elemsdiff;
    }
}
