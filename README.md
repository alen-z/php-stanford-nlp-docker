# Stanford NLP Parser PHP wrapper in Docker

## About Stanford Parser
A natural language parser is a program that works out the grammatical structure of sentences, for instance, which groups of words go together (as "phrases") and which words are the subject or object of a verb. Probabilistic parsers use knowledge of language gained from hand-parsed sentences to try to produce the most likely analysis of new sentences. These statistical parsers still make some mistakes, but commonly work rather well. Their development was one of the biggest breakthroughs in natural language processing in the 1990s.

## Run on your machine
```
docker build -t alen-z/php-stanford-nlp-docker https://github.com/alen-z/php-stanford-nlp-docker.git
docker run --name nlp -p 8000:80 alen-z/php-stanford-nlp-docker
```

Get Docker container shell while running:
```
docker exec -it nlp bash
```

Start closed Docker container:
```
docker start nlp
```

# Usage
## Parse ONE sentence
Go to <code>0.0.0.0:8000/?q=Dogs are the best!</code> to get:
```JSON
{
    "wordsAndTags": [
        [
            "Dogs",
            "NNS"
        ],
        [
            "are",
            "VBP"
        ],
        [
            "the",
            "DT"
        ],
        [
            "best",
            "JJS"
        ],
        [
            "!",
            "."
        ]
    ],
    "penn": {
        "parent": "ROOT",
        "children": [
            {
                "parent": "S",
                "children": [
                    {
                        "parent": "NP",
                        "children": [
                            {
                                "parent": "NNS Dogs",
                                "children": []
                            }
                        ]
                    },
                    {
                        "parent": "VP",
                        "children": [
                            {
                                "parent": "VBP are",
                                "children": []
                            },
                            {
                                "parent": "NP",
                                "children": [
                                    {
                                        "parent": "DT the",
                                        "children": []
                                    },
                                    {
                                        "parent": "JJS best",
                                        "children": []
                                    }
                                ]
                            }
                        ]
                    },
                    {
                        "parent": ". !",
                        "children": []
                    }
                ]
            }
        ]
    },
    "typedDependencies": [
        {
            "type": "nsubj",
            "0": {
                "feature": "best",
                "index": 4
            },
            "1": {
                "feature": "Dogs",
                "index": 1
            }
        },
        {
            "type": "cop",
            "0": {
                "feature": "best",
                "index": 4
            },
            "1": {
                "feature": "are",
                "index": 2
            }
        },
        {
            "type": "det",
            "0": {
                "feature": "best",
                "index": 4
            },
            "1": {
                "feature": "the",
                "index": 3
            }
        },
        {
            "type": "root",
            "0": {
                "feature": "ROOT",
                "index": 0
            },
            "1": {
                "feature": "best",
                "index": 4
            }
        }
    ],
    "legend": {
        "NNS": "noun, plural",
        "VBP": "verb, non-3rd person singular present",
        "DT": "determiner",
        "JJS": "adjective, superlative",
        ".": "punctuation mark, sentence closer",
        "NP": "noun phrase",
        "VP": "verb phrase",
        "nsubj": "nominal subject",
        "cop": "copula",
        "det": "determiner",
        "root": "root"
    },
    "query": "Dogs are the best!"
}
```
## Get raw Stanford Parser output for one or multiple sentences
Use additional <code>raw=true</code> parameter. Go to <code>0.0.0.0:8000/?q=Dogs rock! OK, cats are also...fine.&raw=true</code> to get:
```
Dogs/NNS rock/NN !/.

(ROOT
  (NP
    (NP (NNS Dogs))
    (NP (NN rock))
    (. !)))

root(ROOT-0, Dogs-1)
dep(Dogs-1, rock-2)

OK/UH ,/, cats/NNS are/VBP also/RB .../: fine/NN ./.

(ROOT
  (S
    (INTJ (UH OK))
    (, ,)
    (NP (NNS cats))
    (VP (VBP are)
      (ADVP (RB also))
      (: ...)
      (NP (NN fine)))
    (. .)))

discourse(fine-7, OK-1)
nsubj(fine-7, cats-3)
cop(fine-7, are-4)
advmod(fine-7, also-5)
root(ROOT-0, fine-7)
```
## Tips
If you want to use special characters like <code>&</code> in your sentence encode the input. For example 'cat & mouse' should be <code>cat%20%26%20mouse</code>.
