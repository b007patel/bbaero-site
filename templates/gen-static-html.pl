use HTML::Template;
use File::Slurp;

my $html_content;
my $content_file;

$content_file = $ARGV[0] or die 'Please give a filename!';
$html_content = read_file( $content_file );

my $template = HTML::Template->new(filename => 'base-html-templ');
$template->param(HTML_CONTENT => $html_content);
print $template->output;