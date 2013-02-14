<?php
require("/var/www/mitmunc/template/header_very_basic.php"); 

$SESSION->securityCheck(true, array('secretariat', 'chair'));
$committee = new committee($SESSION->committeeId);
$resolution = new resolution($_GET['resolutionId']);

$committeeName = $committee->committeeName;
$committeeName = str_replace("&amp", "\&", $committeeName);

$storedDate = $resolution->date;
if ($storedDate == "0000-00-00"){
  $timestamp = time();
} else {
  $timestamp = strtotime($storedDate);
}

$latex = "
\\documentclass{article}
\\usepackage{graphicx}
\\usepackage{outlines}
\\usepackage[margin=1in]{geometry}

\\begin{document}
\\begin{center}
\\end{center}
\\includegraphics[width=20mm]{/var/www/mitmunc/files/un.png}
\\label{UN LOGO}
 \\Large{\bf $committee->shortName}\\\\
\\linethickness{.5mm}
\\line(1,0){300} \\\\
\\normalsize{\bf Resolution $resolution->resolutionNum (".date("Y").")
of the MITMUNC $committeeName on " . date("F j, Y", $timestamp) . "\\\\ \\\\
Sponsors: $resolution->sponsors \\\\
Signatories: $resolution->signatories \\\\ \\\\
} \\\\

\indent {\it The $committeeName,}\\\\

";
foreach($resolution->preambulatory as $clause){
    $latex .= '\indent {\it ';
    $splitClause = $clause->splitPhrase(); 
    $latex .= trim(sanitizeLatex($splitClause[0])).'} ';
    $latex .= trim(sanitizeLatex($splitClause[1])).', \\\\'."\n";
}

$latex .= "\n\n";
$latex .= '\begin{outline}[enumerate]'."\n";
foreach($resolution->operative as $clause){
    $latex .= $clause->getOperativeClause(1);
    $latex = $latex."; \n";
}
$latex = substr($latex, 0, -3).".\n";
$latex .= "\end{outline}

\linethickness{.2mm}
\begin{center}
\line(1,0){100}
\end{center}

\end{document}";

$latexFile = "/var/www/mitmunc/files/resolution.tex";
$fh = fopen($latexFile, 'w') or die("can't open file");
fwrite($fh, $latex);
fclose($fh);

shell_exec('cd /var/www/mitmunc/files; /usr/bin/pdflatex '.$latexFile);

$pdfFile = "/var/www/mitmunc/files/resolution.pdf";
$filename = 'resolution_'.$committee->shortName.'_'.$resolution->topicId.'_'.$resolution->resolutionNum.'.pdf';
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Type: application/pdf");
header("Content-Disposition: attachment; filename=$filename");
header("Content-Transfer-Encoding: binary");
readfile($pdfFile);
