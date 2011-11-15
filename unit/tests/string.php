<?php //-->

$loader->load('Eden_String');
$unit->setPackage('Eden_String Tests');

//-------------------------//
// Test 1
$string = Eden_String::get("Unit Test Eden V2");

$unit->assertEquals('Unit Test Eden V2', (string) $string, 'String Format Test');
$unit->assertEquals('unitTestEdenV2', (string) $string->camelize(), 'camelize String');
$unit->assertEquals('unit-test-eden-v2', (string) $string->uncamelize(), 'uncamelize string');
$unit->assertEquals('unit-test-eden-v2', (string) $string->dasherize(), 'dasherize string');
$unit->assertEquals('Unit Test Eden V2', (string) $string->titlize(), 'titlize string');

//pre methods
//Test 1
//-------------------->
$string = Eden_String::get("Unit Test for Dan's Window");

$unit->assertEquals("unit test for dan's window", (string) $string->addslashes()->stripslashes()->strtolower(), "addslashes then stripslashes and strtolower");
$unit->assertEquals(94, $string->bin2hex()->strlen(), 'bin2hex the string then strlen');


//Test 2
//--------------------->
$string = Eden_String::get("Unit Test");
$unit->assertSame("Un\r\nit\r\n T\r\nes\r\nt\r\n", (string) $string->chunk_split(2), 'chunk_split'); //not working

$string = Eden_String::get("Unit Test");
$unit->assertEquals('Unit Test', (string) $string->convert_uuencode()->convert_uudecode(), 'convert_uuencode and back to convert_uudecode');
//echo $string->crypt(CRYPT_MD5);


//Test 3
//--------------------->
$string = Eden_String::get("I'll make a 'history!'");
//echo $string->htmlentities()->html_entity_decode();
$unit->assertSame("I'll make a 'history!'", (string) $string->htmlentities()->html_entity_decode(), 'htmlentities() then html_entity_decode'); //now working
//echo $string;
$unit->assertEquals("I'll make a 'history!'", (string) $string->htmlspecialchars()->htmlspecialchars_decode(), 'htmlspecialchars() to htmlspecialchars_decode()');
$unit->assertEquals("6c24d06f9e32721ed8a6ee445bbf6bb1", (string) $string->ltrim()->md5(), "ltrim string the convert into md5");


//Test 4
//--------------------->
$string = Eden_String::get("Have a good Day!");

$unit->assertEquals("Have-a-good-Day!", (string) $string->str_replace(' ', "-"), "replace space to (-)");
//echo $string->quotemeta();


//Test 5
//--------------------->
$string = Eden_String::get("\t\tThese are a few words");
$unit->assertEquals("\t\tThese are a few words", (string) $string->rtrim(), "rtrim test");
$unit->assertEquals("78d3808d95626fdd53151c50094f02a3859dd0dd", (string) $string->sha1(), "sha1 test");

$string = Eden_String::get("%d word for sprintf %s");
$d = 2;
$s = "data";
$unit->assertEquals("2 word for sprintf data", (string) $string->sprintf($d, $s), "sprintf test");
$unit->assertEquals("2 word for sprintf data_-", (string) $string->str_pad(25, '_-'), "str_pad for string");
$unit->assertEquals("2 word for sprintf data_-2 word for sprintf data_-", (string) $string->str_repeat(2), "str_pad for string");

$string = Eden_String::get("php string");
$unit->assertEquals("cuc fgevat", (string) $string->str_rot13(), "str_rot13 encode");
//echo $string->str_shuffle();

$string = Eden_String::get("php <b>string</b>");
$unit->assertEquals("php (<b>)string</b>", (string) $string->strip_tags('<b>')->str_replace("<b>", "(<b>)"), "strip_tags allowsb tag");

$string = Eden_String::get("d\u\z");
$unit->assertEquals("duz", (string) $string->stripcslashes()->stripslashes(), "stripcslashes() and stripslashes()");
$unit->assertEquals("uz", (string) $string->strpbrk("u"), "strpbrk()");

$string = Eden_String::get("Returns the matched");
$unit->assertEquals("turns the matched", (string) $string->stristr('t'), "stristr()");
$unit->assertEquals("CTAM E", (string) $string->strrev()->strstr('h')->strtok('h')->strtoupper(), "strrev(), strstr(), strtok() and strtoupper()");
$unit->assertEquals("AM d", (string) $string->strtr('E', 'd')->substr_replace('TAM', 0, 4)->substr(1, 4), "strtr() and substr_replace() then substr()");

$string = Eden_String::get("programming techniques ");
$unit->assertEquals("Programming Techniques", (string) $string->trim()->ucfirst()->ucwords(), "trim() and ucfirst() then ucwords()");
$unit->assertEquals("Programming-Techniques", (string) $string->wordwrap(3, '<br>')->str_replace("<br>", "-"), "wordwrap() then str_replace()");

$unit->assertEquals("-PTaceghimnoqrsu", (string) $string->count_chars(3), "count_chars()");
//echo $string->hex2bin(); => undifined=

$string = Eden_String::get("programming %s techniques");
$unit->assertEquals('12', (string) $string->vsprintf(array('29'))->strpos('2'), "vsprintf() and strpos()");

$string = Eden_String::get("dan");
$unit->assertEquals('1', (string) $string->substr_compare('a', 0, 2), "substr_compare");

$string = Eden_String::get("this is it");
$unit->assertEquals('3', (string) $string->substr_count('i'), "substr_count()");