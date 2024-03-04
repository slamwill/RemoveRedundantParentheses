<?php

class Solution {
    
    // Function to redundant brackets
    public static function removeBrackets($Exp) {
        
        // Code here
        $s = str_split($Exp);
        $n = strlen($Exp);
        
        $ans = array_fill(0, $n + 1, 1);
        $lasta = array_fill(0, $n + 1, 0);
        $nxta = array_fill(0, $n + 1, 0);
        
        $l = -1;
        
        // Start Iterating from
        // starting index
        for ($i = 0; $i < $n; $i++) {
            $lasta[$i] = $l;
            if ($s[$i] == '*' || $s[$i] == '+' || $s[$i] == '-' || $s[$i] == '/') {
                $l = $s[$i];
            }
        }
        
        // Start Iterating from
        // last index
        $l = -1;
        
        for ($i = $n - 1; $i >= 0; $i--) {
            $nxta[$i] = $l;
            if ($s[$i] == '*' || $s[$i] == '+' || $s[$i] == '-' || $s[$i] == '/') {
                $l = $s[$i];
            }
        }
        
        $st = [];
        $sign = array_fill(0, 256, -1);
        $mp = array_fill(0, 256, 0);
        $operand = ['*', '+', '-', '/'];
        
        for ($p = 0; $p < $n; $p++) {
            foreach ($operand as $x) {
                $mp[ord($x)] = 0;
                if ($x == $s[$p]) {
                    $sign[ord($x)] = $p;
                }
            }
            if ($s[$p] == '(') {
                array_push($st, $p);
            } elseif ($s[$p] == ')') {
                $i = array_pop($st);
                $j = $p;
                
                $nxt = $nxta[$j];
                $last = $lasta[$i];
                
                // Iterate in operator
                // array
                foreach ($operand as $x) {
                    if ($sign[ord($x)] >= $i) {
                        $mp[ord($x)] = 1;
                    }
                }
                $ok = 0;
                
                if ($i > 0 && $j + 1 < $n && $s[$i - 1] == '(' && $s[$j + 1] == ')') {
                    $ok = 1;
                }
                if ($mp[ord('+')] == 0 && $mp[ord('*')] == 0 && $mp[ord('-')] == 0 && $mp[ord('/')] == 0) {
                    $ok = 1;
                }
                
                if ($last == -1 && $nxt == -1) {
                    $ok = 1;
                }
                if ($last == '/') {
                    // pass
                } elseif ($last == '-' && ($mp[ord('+')] == 1 || $mp[ord('-')] == 1)) {
                    // pass
                } elseif ($mp[ord('-')] == 0 && $mp[ord('+')] == 0) {
                    $ok = 1;
                } else {
                    if (($last == -1 || $last == '+' || $last == '-') && ($nxt == -1 || $nxt == '+' || $nxt == '-')) {
                        $ok = 1;
                    }
                }
                // If the pair is reduntant
                if ($ok == 1) {
                    $ans[$i] = 0;
                    $ans[$j] = 0;
                }
            }
        }
        
        // Final string
        $res = "";
        for ($i = 0; $i < $n; $i++) {
            if ($ans[$i] > 0) {
                $res .= $s[$i];
            }
        }
        return $res;

    }
}

$expressions = array(
    "1*(2+(3*(4+5)))",
    "2 + (3 / -5)",
    "x+(y+z)+(t+(v+w))",
    "2-(2+3)",
    "-(2)-(2+3)",
    "-(2+3)"
);

foreach($expressions as $expression) {
    // Function call
    $result = Solution::removeBrackets($expression);
    var_dump($result);
}

?>
