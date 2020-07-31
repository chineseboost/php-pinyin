# PHP Pinyin

[![BuildStatus](https://travis-ci.org/chineseboost/php-pinyin.svg?branch=master)](https://travis-ci.org/chineseboost/php-pinyin)
[![Coverage Status](https://coveralls.io/repos/github/chineseboost/php-pinyin/badge.svg?branch=master)](https://coveralls.io/github/chineseboost/php-pinyin?branch=master)
[![StyleCI](https://github.styleci.io/repos/231220184/shield?branch=master)](https://github.styleci.io/repos/231220184)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

Pinyin and hanzi tools in pure PHP | 纯PHP的汉语拼音和汉字工具

You can try a web version of this here: [https://www.chineseboost.com/tools/hanzi-pinyin-conversion](https://www.chineseboost.com/tools/hanzi-pinyin-conversion)

## Usage

Install via composer:

```bash
composer require chineseboost/php-pinyin
```

### Converting hanzi into pinyin

You can convert hanzi strings into pinyin with a furthest-forward matching
strategy.

php-pinyin handles a lot of cases that other pinyin generation tools do not,
including many 多音字, 儿化 and common mis-parsings.

```php
<?php

use Pinyin\Hanzi\HanziSentence;

(new HanziSentence('科学家的工作就是对理论加以检验。'))->asPinyin()->toneMarked();
// "Kēxuéjiā de gōngzuò jiùshì duì lǐlùn jiāyǐ jiǎnyàn."

(new HanziSentence('他下了车，扑哧扑哧地穿过泥地去开门。'))->asPinyin()->toneMarked();
// "Tā xià le chē, pū chī pū chī de chuānguò ní dì qù kāimén."

(new HanziSentence('我兒子真的是一點兒生活常識都沒有！'))->asPinyin()->toneMarked();
// "Wǒ érzi zhēn de shì yīdiǎnr shēnghuó chángshí dōu méiyǒu!"

(new HanziSentence('食品供给'))->asPinyin()->toneMarked();
// "Shípǐn gōngjǐ"

(new HanziSentence('政府将在2015年对旅游行业加以规范。'))->asPinyin()->toneMarked();
// "Zhèngfǔ jiāng zài èr líng yī wǔ nián duì lǚyóu hángyè jiāyǐ guīfàn."

(new HanziSentence('我已经累得不得了了。'))->asPinyin()->toneMarked();
// "Wǒ yǐjīng lèi de bùdéliǎo le."

```

### Working with pinyin

You can also work directly with pinyin strings, for example to convert from
tone numbers to tone marks.

It does not matter if the source string has a mix of tone numbers and tone
marks, so this can also be used to normalise a pinyin string.

```php
<?php

use Pinyin\PinyinSentence;

$sentence = new PinyinSentence('Ta1 zen3me hai2 mei2 xia4lai2 ne?');
$sentence->toneMarked();
// "Tā zěnme hái méi xiàlái ne?"

$sentence = new PinyinSentence(
    'Cong2 bāshi2 lóu ke3yǐ kan4 dào zheng3gè cheng2shì, zan2men0 shang4qù kan4 yīxia4 ba5.'
);
$sentence->toneMarked();
// "Cóng bāshí lóu kěyǐ kàn dào zhěnggè chéngshì, zánmen shàngqù kàn yīxià ba."
```
