<?php
/**
 * Created by PhpStorm.
 * User: clicker
 * Date: 25/04/17
 * Time: 18:42
 */

require __DIR__ . '/../vendor/autoload.php';

$grammatical_relations = array(
    'acl' => 'clausal modifier of noun',
    'acl:relcl' => 'relative clause modifier',
    'advcl' => 'adverbial clause modifier',
    'advmod' => 'adverbial modifier',
    'amod' => 'adjectival modifier',
    'appos' => 'appositional modifier',
    'aux' => 'auxiliary',
    'auxpass' => 'passive auxiliary',
    'case' => 'case marking',
    'cc' => 'coordination',
    'cc:preconj' => 'preconjunct',
    'ccomp' => 'clausal complement',
    'compound' => 'compound',
    'compound:prt' => 'phrasal verb particle',
    'conj' => 'conjunct',
    'cop' => 'copula',
    'csubj' => 'clausal subject',
    'csubjpass' => 'clausal passive subject',
    'dep' => 'dependent',
    'det' => 'determiner',
    'det:predet' => 'predeterminer',
    'discourse' => 'discourse element',
    'dislocated' => 'dislocated elements',
    'dobj' => 'direct object',
    'expl' => 'expletive',
    'foreign' => 'foreign words',
    'goeswith' => 'goes with',
    'iobj' => 'indirect object',
    'list' => 'list',
    'mark' => 'marker',
    'mwe' => 'multi-word expression',
    'name' => 'name',
    'neg' => 'negation modifier',
    'nmod' => 'nominal modifier',
    'nmod:npmod' => 'noun phrase as adverbial modifier',
    'nmod:poss' => 'possessive nominal modifier',
    'nmod:tmod' => 'temporal modifier',
    'nsubj' => 'nominal subject',
    'nsubjpass' => 'passive nominal subject',
    'nummod' => 'numeric modifier',
    'parataxis' => 'parataxis',
    'punct' => 'punctuation',
    'remnant' => 'remnant in ellipsis',
    'reparandum' => 'overridden disfluency',
    'root' => 'root',
    'vocative' => 'vocative',
    'xcomp' => 'open clausal complement'
);

$penn_treebank = array(
    // POS
    'CC' => 'conjunction, coordinating',
    'CD' => 'cardinal number',
    'DT' => 'determiner',
    'EX' => 'existential there',
    'FW' => 'foreign word',
    'IN' => 'conjunction, subordinating or preposition',
    'JJ' => 'adjective',
    'JJR' => 'adjective, comparative',
    'JJS' => 'adjective, superlative',
    'LS' => 'list item marker',
    'MD' => 'verb, modal auxillary',
    'NN' => 'noun, singular or mass',
    'NNS' => 'noun, plural',
    'NNP' => 'noun, proper singular',
    'NNPS' => 'noun, proper plural',
    'PDT' => 'predeterminer',
    'POS' => 'possessive ending',
    'PRP' => 'pronoun, personal',
    'PRP$' => 'pronoun, possessive',
    'RB' => 'adverb',
    'RBR' => 'adverb, comparative',
    'RBS' => 'adverb, superlative',
    'RP' => 'adverb, particle',
    'SYM' => 'symbol',
    'TO' => 'infinitival to',
    'UH' => 'interjection',
    'VB' => 'verb, base form',
    'VBZ' => 'verb, 3rd person singular present',
    'VBP' => 'verb, non-3rd person singular present',
    'VBD' => 'verb, past tense',
    'VBN' => 'verb, past participle',
    'VBG' => 'verb, gerund or present participle',
    'WDT' => 'wh-determiner',
    'WP' => 'wh-pronoun, personal',
    'WP$' => 'wh-pronoun, possessive',
    'WRB' => 'wh-adverb',
    '.' => 'punctuation mark, sentence closer',
    ',' => 'punctuation mark, comma',
    ':' => 'punctuation mark, colon',
    '(' => 'contextual separator, left paren',
    ')' => 'contextual separator, right paren',
    // phrases
    'NP' => 'noun phrase',
    'PP' => 'prepositional phrase',
    'VP' => 'verb phrase',
    'ADVP' => 'adverb phrase',
    'ADJP' => 'adjective phrase',
    'SBAR' => 'subordinating conjunction',
    'PRT' => 'particle',
    'INTJ' => 'interjection'
);

// param
$cwd = getcwd();
$sentence = $_GET['q'];
$raw = $_GET['raw'];

$parser = new StanfordNLP\Parser($cwd . '/stanford-parser-full-2016-10-31/stanford-parser.jar', $cwd . '/stanford-parser-full-2016-10-31/stanford-parser-3.7.0-models.jar');
$result = $parser->parseSentence($sentence);

$explanation = array();
$iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($result));
foreach ($iterator as $key => $value) {
    if (array_key_exists($value, $grammatical_relations)) {
        $explanation[$value] = $grammatical_relations[$value];
    }
    if (array_key_exists($value, $penn_treebank)) {
        $explanation[$value] = $penn_treebank[$value];
    }
}

$result['legend'] = $explanation;
$result['query'] = $sentence;

if ($raw === 'true') {
    echo $parser->getOutput();
} else {
    echo json_encode($result, JSON_PRETTY_PRINT);
}