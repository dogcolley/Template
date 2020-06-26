<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

/******************

스팸 로그 테스트 2019-05-02 이충희 : soullez@naver.com

--> /extend/spam_chk.extend.php 파일 추가되었습니다.
--> /테마/skin/board/스킨명/write_update.tail.php 파일 추가되었습니다.

*******************/

// 특수문자에서 제외시킬 단어는 아래 특수문자에서 제거해주세요.
$special_char = "＃＆＆＠§〓▒▤▥▨▧▦▩♨☜☞¶†‡♭㉿㈜№㏇™㏂㏘℡®ªº─│┌┐┘└├┬┤┴┼━┃┏┓┛┗┣┳┫┻╋┠┯┨┷┿┝┰┥┸╂┒┑┚┙┖┕┎┍┞┟┡┢┦┧┩┪┭┮┱┲┵┶┹┺┽┾╀╁╃╄╅╆╇╈╉╊＋－＜＝＞±×÷≠≤≥∞∴♂♀∠⊥⌒∂∇≡≒≪≫√∽∝∵∫∬∈∋⊆⊇⊂⊃∪∩∧∨￢⇒⇔∀∃∮∑∏！＇，．／：；？＾＿｀｜￣、。·‥…¿ː＂”｛｝‘’“”＄％￦Ｆ′″ㄽㄾㄿㅀㄽㄾㄿㅀㅥㅦㅧㅨㅩㅪㅫㅬㅭㅮㅯㅰㅱㅲㅳㅴㅵㅶㅷㅸㅹㅺㅻㅼㅽㅾㅿㆀㆁㆂㆄㆅㆆㆇㆈㆉㆊㆋㆌㆍ½⅓⅔¼¾⅛⅜⅝⅞¹²³⁴ⁿ₁₂₃₄ＡＢＣＤＥＦＧＨＩＪＫＬＭＮＯＰＱＲＳＴＵＶＷＸＹＺａｂｃｄｅｆｇｈｉｊｋｌｍｎｏｐｑｒｓｔｕｖｗｘｙｚΑΒΓΔΕΖΗΘΙΚΛΜΝΞΟΠΡΣΤΥΦΧΨαβγδεζηθικλμνξοπρστυφχψω０１２３４５６７８９ⅰⅱⅲⅳⅴⅵⅶⅷⅸⅹⅠⅡⅢⅣⅤⅥⅦⅧⅨⅩꊒꊓꊔꊕꊖꊗꊘꊙꊚꊛꊈꊉꊊꊋꊌꊍꊎꊏꊐꊑꊦꊧꊨꊩꊪꊫꊬꊭꊮꊯꊝꊞꊟꊠꊡꊢꊣꊤꊥꋍꋎꋏꋐꋑꋒꋓꋔꋕꋖꋠꋡꋢꋣꋤꋥꋦꋧꋨꋩꊰꊱꊲꊳꊴꊵꊶꊷꊸꊹꊺꊻꊼꊽꊾꊿꋀꋁꋂ꓌꓍꓎꓏ꓐꓑꓒꓓꓔꓕ꒐꒑꒒꒓꒔꒕꒖꒗꒘꒙꒮꒯꒰꒱꒲꒳꒴꒵꒶꒷꓂꓃꓄꓅꓆꓇꓈꓉꓊꓋ꓖꓗꓘꓙꓚꓛꓜꓝꓞꓟꓪꓫꓬꓭꓮꓯꓰꓱꓲꓳꓠꓡꓢꓣꓤꓥꓦꓧꓨꓩꈂꈃꈄꈅꈆꈇꈈꈉꈊꈋꈌꈍꈎꈏꈐꈑꈒꈓꈔꈕꉭꉮꉯꉰꉱꉲꉳꉴꉵꉶꉷꉸꉹꉺꉻꉼꉽꉾꉿꊀꆗꆘꆙꆚꆛꆜꆝꆞꆟꆠꆡꆢꆣꆤꆥꆦꆧꆨꆩꆪꄽꄾꄿꅀꅁꅂꅃꅄꅅꅆ㊀㊁㊂㊃㊄㊅㊆㊇㊈㊉㈠㈡㈢㈣㈤㈥㈦㈧㈨㈩㆒㆓㆔㆕㆖㆗㆘㆙㆚㆛ꈖꈗꈘꈙꈚꈛꈜꊁꊂꊃꊄꊅꊆꊇꆫꆬꆭꆮꆯꆰꆱ㊊㊋㊌㊍㊎㊏㊐㈪㈫㈬㈭㈮㈯㈰㋀㋁㋂㋃㋄㋅㋆㋇㋈㋉㋊㋋㏠㏡㏢㏣㏤㏥㏦㏧㏨㏩㏪㏫㏬㏭㏮㏯㏰㏱㏲㏳㏴㏵㏶㏷㏸㏹㏺㏻㏼㏽㏾㍘㍙㍚㍛㍜㍝㍞㍟㍠㍡㍢㍣㍤㍥㍦㍧㍨㍩㍪㍫㍬㍭㍮㍯㍰ꆲꆳꆴꆵꆶꆷꆸꆹꆺꆻꆼꆽꆾꆿꇀꇁꇂꇃꇄꇅꇆꇇꇈꇉꇊꇋꇌꇍꇎꇏꇐꇑꇒꇓꇔꇕꇖꇗꇘꇙꇚꇛꇜꇝꇞꇟꇠꇡꇢꇣꇤꇥꈝꈞꈟꈠꈡꈢꈣꈤꈥꈦꈧꈨꈩꈪꈫꈬꈭꈮꈯꈰꈱꈲꈳꈴꈵꈶꈷꈸꈹꈺꈻꈼꈽꈾꈿꉀꉁꉂꉃꉄꉅꉆꉇꉈꉉꉊꉋꉌꉍꉎꉏꉐꍽꍾꍿꎀꎁꎂꎃꎄꎅꎆꎇꎈꎉꎊꎋꎌꎍꎎꎏꎐꎑꎒꎓꎔꎕꎖꅇꅈꅉꅊꅋꅌꅍꅎꅏꅐꅑꅒꅓꅔꅕꅖꅗꅘꅙꅚꅛꅜꅝꅞꅟꅠꅡꅢꅣꅤꅥꅦꅧꅨꅩꅪꅫꅬꅭꅮꅯꅰꅱꅲꅳꅴꅵꅶꅷꅸꅹꅺａｂｃｄｅｆｇｈｉｊｋｌｍｎｏｐｑｒｓｔｕｖｗｘｙｚꂛꂜꂝꂞꂟꂠꂡꂢꂣꂤꂥꂦꂧꂨꆉꆊꆋꆌꆍꆎꆏꆐꆑꆒꆓꆔꆕꆖꇴꇵꇶꇷꇸꇹꇺꇻꇼꇽꇾꇿꈀꈁꉟꉠꉡꉢꉣꉤꉥꉦꉧꉨꉩꉪꉫꉬꂩꂪꂫꂬꂭꂮꂯꂰꂱꂲꃳꃴꃵꃶꃷꃸꃹꃺꃻꃼꇦꇧꇨꇩꇪꇫꇬꇭꇮꇯꇰꇱꇲꇳꅻꅼꅽꅾꅿꆀꆁꆂꆃꆄꆅꆆꆇꆈꉑꉒꉓꉔꉕꉖꉗꉘꉙꉚꉛꉜꉝꉞꂳꂴꂵꂶꂷꂸꂹꂺꂻꂼꂽꂾꂿꃀꃁꃂꃃꃄꃅꃆꃇꃈꃉꃊꃋꃌꃍꃎꃏꃐꃑꃒꃓꃔꃕꃖꃗꃘꃙꃚꃛꃜꃝꃞꃟꃠꃡꃢꃣꃤꃥꃦꃧꃨꃩꃪꃫꃬꃭꃮꃯꃰꃱꃲꃽꃾꃿꄀꄁꄂꄃꄄꄅꄆꄇꄈꄉꄊꄋꄌꄍꄎꄏꄐꄑꄒꄓꄔꄕꄖꄗꄘꄙꄚꄛꄜꄝꄞꄟꄠꄡꄢꄣꄤꄥꄦꄧꄨꄩꄪꄫꄬꄭꄮꄯꄰꄱꄲꄳꄴꄵꄶꄷꄸꄹꄺꄻꄼꍟꍠꍡꍢꍣꍤꍥꍦꍧꍨꍩꍪꍯꍺꍻꍼꎗꎘꎙꎚꎛꎜꎝꎧꎨꏁꏂꎯꍫꍬꍭꍮꎞꎟꎠꎡꎪꍰꍱꍲꍳꍴꍵꍶꍷꍸꍹꎼꎽꎾꎿꎮꎰꎲꎬꎢꎣꎤꎥꎦꎩꎫꎭꎱꎳꎶꎷꎸꎹꎺꎻꏀꏃꏄ困囷囹固囿圁圂圃圄圈圉圊國圍園圓圖團圜囚因囦囫囮囘囙囜囝囡团団囤囥囧囨囩囪囬园囯囱囲図围囵囶囸囻囼国图圀圅圆圇圌圎圏圐圑圔圕圗圙圚圛圝圞㈱㈲㈳㈴㈵㈶㈷㈸㈹㈺㈻㈼㈽㈾㈿㉀㉁㉂㉃㊑㊒㊓㊔㊕㊖㊗㊘㊙㊚㊛㊜㊝㊞㊟㊠㊡㊢㊣㊤㊥㊦㊧㊨㊩㊪㊫㊬㊭㊮㊯㊰㋐㋑㋒㋓㋔㋕㋖㋗㋘㋙㋚㋛㋜㋝㋞㋟㋠㋡㋢㋣㋤㋥㋦㋧㋨㋩㋪㋫㋬㋭㋮㋯㋰㋱㋲㋳㋴㋵㋶㋷㋸㋹㋺㋻㋼㋽㋾㌀㌁㌂㌃㌄㌅㌆㌇㌈㌉㌊㌋㌌㌍㌎㌏㌐㌑㌒㌓㌔㌕㌖㌗㌘㌙㌚㌛㌜㌝㌞㌟㌠㌡㌢㌣㌤㌥㌦㌧㌨㌩㌪㌫㌬㌭㌮㌯㌰㌱㌲㌳㌴㌵㌶㌷㌸㌹㌺㌻㌼㌽㌾㌿㍀㍁㍂㍃㍄㍅㍆㍇㍈㍉㍊㍋㍌㍍㍎㍏㍐㍑㍒㍓㍔㍕㍖㍗ᐰᐱᐲᐳᐴᐵᐶᐷᐸᐹᐺᐻᐼᐽᐾᐿᑀᑁᑂᑃᑄᑅᑆᑇᑈᑉᑊᑋᑌᑍᑎᑏᑐᑑᑒᑓᑔᑕᑖᑗᑘᑙᑚᑛᑜᑝᑞᑟᑠᑡᑢᑣᑤᑥᑦᑧᑨᑩᑪᑫᑬᑭᑮᑯᑰᑱᑲᑳᑴᑵᑶᑷᑸᑹᑺᑻᑼᑽᑾᑿᒀᒁᒂᒃᒄᒅᒆᒇᒈᒉᒊᒋᒌᒍᒎᒏᒐᒑᒒᒓᒔᒕᒖᒗᒘᒙᒚᒛᒜᒝᒞᒟᒠᒡᒢᒣᒤᒥᒦᒧᒨᒩᒪᒫᒬᒭᒮᒯᓐᓑᓒᓓᓔᓕᓖᓗᓘᓙᓚᓛᓜᓝᓞᓟᓠᓡᓢᓣᓤᓥᓦᓧᓨᓩᓪᓫᓬᓭᓮᓯᓰᓱᓲᓳᓴᓵᓶᓷᓸᓹᓺᓻᓼᓽᓾᓿᔐᔑᔒᔓᔔᔕᔖᔗᔘᔙᔚᔛᔜᔝᔞᔟᔠᔡᔢᔣᔤᔥᔦᔧᔨᔩᔪᔫᔬᔭᔮᔯᔰᔱᔲᔳᔴᔵᔶᔷᔸᔹᔺᔻᔼᔽᔾᔿᕀᕁᕂᕃᕄᕅᕆᕇᕈᕉᕊᕋᕌᕍᕎᕏᕐᕑᕒᕓᕔᕕᕖᕗᕘᕙᕚᕛᕜᕝᕞᕟᕠᕡᕢᕣᕤᕥᕦᕧᕨᕩᕪᕫᕬᕭᕮᕯᕰᕱᕲᕳᕴᕵᕶᕷᕸᕹᕺᕻᕼᕽᕾᕿᖠᖡᖢᖣᖤᖥᖦᖧᖨᖩᖪᖫᖬᖭᖮᖯᖰᖱᖲᖳᖴᖵᖶᖷᖸᖹᖺᖻᖼᖽᖾᖿᗀᗁᗂᗃᗄᗅᗆᗇᗈᗉᗊᗋᗌᗍᗎᗏᗐᗑᗒᗓᗔᗕᗖᗗᗘᗙᗚᗛᗜᗝᗞᗟᗠᗡᗢᗣᗤᗥᗦᗧᗨᗩᗪᗫᗬᗭᗮᗯᗰᗱᗲᗳᗴᗵᗶᗷᗸᗹᗺᗻᗼᗽᗾᗿᘀᘂᘃᘄᘅᘆᘇᘈᘉᘊᘋᘌᘍᘎᘏᘐᘑᘒᘓᘔᘕᘖᘗᘘᘙᘚᘛᘜᘝᘞᘟᘠᘡᘢᘣᘤᘥᘦᘧᘨᘩᘪᘫᘬᘭᘮᘯᘰᘱᘲᘳᘴᘵᘶᘷᘸᘹᘺᘻᘼᘽᘾᘿᙀᙁᙂᙃᙄᙅᙆᙇᙈᙉᙊᙋᙌᙍᙎᙏᙐᙑᙒᙓᙔᙕᙖᙗᙘᙙᙚᙛᙜᙝᙞᙟᙠᙡᙢᙣᙤᙥᙦᙧᙨᙩᙪᙫᙬᙯᙰᙱᙲᙳᙴᙵᙶઁંઃઅઆઇઈઉઊઋઍએઐઑઓઔકખગઘઙચછજઝઞટઠડઢइउऊऋऌकखगघङचछजझञटठडढणतदनऩपफबभमयरऱलळऴवशषसहक़ख़ग़ज़ड़ढ़फ़य़ॠॡԱԲԳԴԵԶԷԸԹԺԻԼԽԾԿՀՁՂՃՄՅՆՇՈՉՊՋՌՍՎՏՐաբգդեզէըթժիլխծկհձղճմյնոչպջռսվտրցւփքօֆևឃងចឆឈញដឋឌឍណតថទធនបផភមយលឝឞសឡអឤឥឦឨឩឬឭឯឰឱឲឳ឴឵ា១២៣៥៦៧៨៩ஆஇஈஊஎஏஐஒஓஔஂஃாிௗஙஜஞணநனமயறலளழவஸஹ௧௨௩௪௫абвгдежзийклмнопрстуфхцчшщъыьэюяёђѓєѕіїјљњћќўџހށނރބޅކއވމފދތލގޏސޑޒޓޔޕޖޗޘޙޚޛޜޝޞޟޠޡޢޣޤޥਕਗਘਙਚਛਜਝਞਟਡਢਣਤਥਦਧਨਪਫਬਭਯਰਲਲ਼ਵਸਹਖ਼ਗ਼ਜ਼ੜਫ਼ଆଇଈଉଊଋଌଐଓଔଖଗଘଙଛଜଝଞଟଢଣତଥଧନପଫବଭମଯରଳଶଷସହంఃఅఆఇఈఉఊఋఌఎఏఐఒఓఔకఖగఘఙచఛజఝఞటఠడఢణతథదధనపఫబభమయరఱలళవశషహాిౕౖౠౡ౨౩౪౫౬౭౮౯ಂಃಅಆಇಈಉಊಋಌಎಏಐಒಓಔಕಖಗಘಙಚಛಜಝಞಟಠಡಢಣತಥದಧನಪಫಬಭಮರಱಲಳವಶಷ૦૧૨૩૪૫૬૭૮૯੦੧੨੩੪੫੬੭੮੯║╒╓╔╕╖╗╘╙╚╛╜╝╞╟╠╡╢╣╤╥╦╧╨╩╪╫╬ꋰꋱꋲꋳꋴꋵꋶꋷꋸꋹꋺꋻꋼꋽꀢꀣꀤꀥꀦꀧꀨꀩꀪꀫꀬꀭꀲꀳ⇒⇔ꀮꀯꀰꀱ←↑→↓↔↕↖↗↘↙ꀹꀺꀻꀼꀽꁼꁽꁾꁿꀴꀵꀶꀷꀸꀾꀿꁂꁃꁄꁅꎴꎵꍖꍗꍘꍙꍚꍛꍜꍝ܁܂܃܄܅܆܇܈܉ꌈꌉꌊꌋꌌꌍꌎꌏꌐꌀꌁꀞꀟꀆꀇꀈꀉꀊꀋꀌꀍꀎꀏꀐꀑꀒꀓꀔꀕꀖꀗꀘꀙꀚꀛꀜꀝ༼༽༾༿⌠⌡ꌼꌽꌾꌿꍀꍁꍂꍃꍄꍅꍆꍇꍈꍉꍐꍑꍊꍋꍌꍍꍎꍏꍒꍓꍔꍕ᚛᚜ꌑꌒꌓꌔꌕꌖꌗꌘꌙꌚꌛꌜꌝꌞꌟꌠꌡꌢꌣꌤꌥꌦꌧꌨꌩꌪꌫꌬꌭꌮꌯꌰꌱꌲꌳꌴꌵꌶꌷꏪꏫꏬ▒▓░ꁳꁴꁵꁶꁷꁸꁣꁤꁥꁦꁧꁨꁩꁪꁫꁬꁭꁮꁯꁰꁱꁲ◆◇◈ꂔꂕꂗꂘꂙ▣▤▥▦▧▨▩ᚠᚡᚢᚣᚤᚥᚦᚧᚨᚩᚪᚫᚬᚭᚮᚯᚰᚱᚲᚳᚴᚵᚶᚷᚸᚹᚺᚻᚼᚽᚾᚿᛀᛁᛂᛃᛄᛅᛆᛇᛈᛉᛊᛋᛌᛍᛎᛏᛐᛑᛒᛓᛔᛕᛖᛗᛘµ¶܏ᛙᛚᛛᛜᛝᛞᛟᛠᛡᛢᛣᛤᛥᛦᛧᛨᛩᛪ᛫᛬᛭ᛮᛯᛰ ᚁᚂᚃᚄᚅᚆᚇᚈᚉᚊᚋᚌᚍᚎᚏᚐᚑᚒᚓᚔꁌꁍꁎꁏꁐ♩♪♫♬♭ꁔꁕꁖꁗꁛꁜꁝꁞꁟꁠꁡꁑꁒꁓꁘꁙꁚꁢꁇ܀܊܋܌܍¤፨₪ꂇ◘◙⌂☺☻♀♂ꋭꋯާިީުޫެޭޮᚗᚘ፡።፣፤፥፦፧‘’‚‛“”„‥…‧′″〝〞〟ꏯꏰꏱꏲꏳꏴꏣꏤꏥꏦꏧꏨꏩꏛꏜꏝꏞꏟꏠꏡꏢꏍꏎꏏꏐꏑꏒꏇꏈꏔꏕꏖꏮꂚꏅꏚꏋ☼ꀀꁋꂊꂐꏗꏘꏙꁉꏆꁹꁺꁻꂂꂃꂅꂆꂈꂉꏊꏓꂋꂌꂍꂎꂏꂑꂒꂓꂖ〒";

$special_char .= "Å￠￡￥¤℉‰€㎕㎗㏄㎙㎚㎛㎜㎝㎞㎍㎎㎏㏏㎈㎉㏈㎧㎨㎰㎱㎲㎳㎴㎵㎶㎷㎸㎹㎀㎁㎂㎃㎄㎺㎻㎼㎽㎾㎿㎐㎑㎒㎓㎔㏀㏁㎊㎋㎌㏖㏅㎭㎮㎯㏛㎩㎪㎫㎬㏝㏐㏓㏃㏉㏜㏆";

$special_char .= "〔〕〈〉《》「」『』【】㉠㉡㉢㉣㉤㉥㉦㉧㉨㉩㉪㉫㉬㉭㉮㉯㉰㉱㉲㉳㉴㉵㉶㉷㉸㉹㉺㉻㈀㈁㈂㈃㈄㈅㈆㈇㈈㈉㈊㈋㈌㈍㈎㈏㈐㈑㈒㈓㈔㈕㈖㈗㈘㈙㈚㈛ⓐⓑⓒⓓⓔⓕⓖⓗⓘⓙⓚⓛⓜⓝⓞⓟⓠⓡⓢⓣⓤⓥⓦⓧⓨⓩ⒜⒝⒞⒟⒠⒡⒢⒣⒤⒥⒦⒧⒨⒩⒪⒫⒬⒭⒮⒯⒰⒱⒲⒳⒴⒵⑴⑵⑶⑷⑸⑹⑺⑻⑼⑽⑾⑿⒀⒁⒂①②③④⑤⑥⑦⑧⑨⑩⑪⑫⑬⑭⑮⑴⑵⑶⑷⑸⑹⑺⑻⑼⑽⑾⑿⒀⒁⒂ⓐⓑⓒⓓⓔⓕⓖⓗⓘⓙⓚⓛⓜⓝⓞⓟⓠⓡⓢⓣⓤⓥⓦⓧⓨⓩ⒜⒝⒞⒟⒠⒡⒢⒣⒤⒥⒦⒧⒨⒩⒪⒫⒬⒭⒮⒯⒰⒱⒲⒳⒴⒵㉮㉯㉰㉱㉲㉳㉴㉵㉶㉷㉸㉹㉺㉻㈎㈏㈐㈑㈒㈓㈔㈕㈖㈗㈘㈙㈚㈛㈀㈁㈂㈃㈄㈅㈆㈇㈈㈉㈊㈋㈌㈍㉠㉡㉢㉣㉤㉥㉦㉧㉨㉩㉪㉫㉬㉭";


$strlen = "";
$fchar = "";
$spchar = "";
$postsubj = "";
$postcont = "";

$strlen = mb_strlen( $special_char, 'utf-8' );

for($i=0; $i<$strlen; $i++) {
	$fchar = mb_substr ($special_char, $i, 1, 'UTF-8');
	$spchar .= $fchar.",";
}

$postsubj = trim($_POST['wr_subject']);
//$postcont = trim($_POST['wr_content']);


if(isset($_POST['wr_content'])) {
	$postcont = trim($_POST['wr_content']);
	$postcont = preg_replace("#[\\\]+$#", "", $postcont);
}

$filter_char = explode(",", trim($spchar));

$f_stripos = "";
$f_stripos2 = "";
$char_subj = "";
$char_cont = "";
$char_data = "";

// 허용하지 않은 특수문자 검사
for ($i=0; $i<count($filter_char)-1; $i++) {
    $fil_str = $filter_char[$i];
	
	// 제목 필터링 (찾으면 중지)
    $f_stripos = strpos($postsubj, $fil_str);
    if ($f_stripos !== false) {
        $char_subj .= $fil_str.",";
    }

    // 내용 필터링 (찾으면 중지)
    $f_stripos2 = strpos($postcont, $fil_str);
    if ($f_stripos2 !== false) {
        $char_cont .= $fil_str.",";
    }
}

// 글을 일단 등록하고 수정할때 악용할수도 있으므로 수정일때도 스팸 확인
if($w == "" || $w == "u") {
	
	$a_tag_chk = "";
	$video_tag_chk = "";
	$embed_tag_chk = "";
	$img_tag_chk = "";
	$a_tag_attr_chk = "";
	$br_tag_chk = "";
	$a_all_cnt = 0;
	$embed_all_cnt = 0;

	// img 태그 설정
	$img_attr = array("src", "style", "alt", "title", "width", "height"); // 허용 할 img 태그 속성
	foreach($img_attr as $value) {
		$img_attr2 .= $value."|";
	}
	$img_attr2 = rtrim($img_attr2, "|");

	// a태그 설정
	$a_cnt = 3; // 개 까지 허용
	$a_attr = array("href", "target", "title", "alt"); // 허용 할 a 태그 속성
	foreach($a_attr as $value) {
		$a_attr2 .= $value."|";
	}
	$a_attr2 = rtrim($a_attr2, "|");

	// **** a태그 검사 **** //
	$match_all_a = array();
	preg_match_all("/<a[^>]+>/i", $postcont, $match_all_a); 
	$a_all_cnt = count($match_all_a[0]); // 총 사용된 a 태그 개수

	if($a_all_cnt > $a_cnt) {
		$a_tag_chk = 1;
	}

	// **** video태그 검사 **** //
	$match_all_video = array();
	preg_match_all("/<video[^>]+>/i", $postcont, $match_all_video); 
	$video_all_cnt = count($match_all_video[0]); // 총 사용된 video 태그 개수

	if($video_all_cnt > 0) {
		$video_tag_chk = 1;
	}


	// **** embed태그 검사 **** //
	$match_all_embed = array();
	preg_match_all("/<embed[^>]+>/i", $postcont, $match_all_embed); 
	$embed_all_cnt = count($match_all_embed[0]); // 총 사용된 embed 태그 개수

	if($embed_all_cnt > 0) {
		$embed_tag_chk = 1;
	}


	// **** img태그 속성 검사 정규식 **** //
	$match_all_img = array();
	preg_match_all("/<img[^>]+>/i", $postcont, $match_all_img); 

	$img_attr_Arr = array();
	$match_img_tag = array();

	$k=0;
	foreach($match_all_img[0] as $value) {
		// 모든  속성을 출력
		preg_match_all("/(".$img_attr2.")*= *[\"\']{0,1}([^\"\'\ \>]*)/i", $value, $match_img_tag[$k]); 
		$k++;
	}

	foreach($match_img_tag as $value) {
		
		// 허용되지 않은 속성만 걸러냄
		$k=0;
		foreach($value[1] as $v) {
			if(empty($v[$k])) {
				$attr_fil = 1;
				array_push($img_attr_Arr, $attr_fil);
			}
			$k++;
		}

		// 허용되지 않은 속성만 걸러냄
		//$attr_fil = array_values(array_diff($value[1], $img_attr));
	}

	if(in_array(1, $img_attr_Arr)) {
		$img_tag_chk = 1;
	}


	// **** a태그 속성 검사 정규식 **** //
	$match_all_a2 = array();
	preg_match_all("/<a[^>]+>/i", $postcont, $match_all_a2); 

	$a_attr_Arr = array();
	$match_a_tag = array();

	$k=0;
	foreach($match_all_a2[0] as $value) {
		// 모든  속성을 출력
		preg_match_all("/(".$a_attr2.")*= *[\"\']{0,1}([^\"\'\ \>]*)/i", $value, $match_a_tag[$k]); 
		$k++;
	}

	foreach($match_a_tag as $value) {
		
		// 허용되지 않은 속성만 걸러냄
		$k=0;
		foreach($value[1] as $v) {
			if(empty($v[$k])) {
				$attr_fil2 = 1;
				array_push($a_attr_Arr, $attr_fil2);
			}
			$k++;
		}

		// 허용되지 않은 속성만 걸러냄
		//$attr_fil2 = array_values(array_diff($value[1], $img_attr));
	}

	if(in_array(1, $a_attr_Arr)) {
		$a_tag_attr_chk = 1;
	}

	$char_subj = rtrim($char_subj, ","); // 제목에 들어간 불법 특수문자
	$char_cont = rtrim($char_cont, ","); // 내용에 들어간 불법 특수문자
	
	// 사용된 모든 불법 특수문자 모음
	$char_data = $char_subj.",".$char_cont;
	$char_data = rtrim($char_data, ",");

	$cap_val = "";
	$cap_chk = "";

	if ($member['mb_id']) {
		$wr_name = addslashes(clean_xss_tags($board['bo_use_name'] ? $member['mb_name'] : $member['mb_nick']));
	} else {
		// 비회원의 경우 이름이 누락되는 경우가 있음
		$wr_name = clean_xss_tags(trim($_POST['wr_name']));
	}

	if(get_session('ss_captcha_key') && $member['mb_id']) { // wr_name 값이랑 캡챠 값이 있으면 체크
		$cap_val = get_session('ss_captcha_key');
		$cap_chk = 1;
	}else{
		$cap_val = get_session('ss_captcha_key');
		$cap_chk = chk_captcha();
	}
	
	// 캡챠 값이 없지만 매크로가 아닌 실제 입력이면 회원으로 간주
	if(!$cap_val && $_POST['real_typing']) {
		$cap_val = "member";
		$cap_chk = 1;
	}

	// 관리자로 판단하여 캡챠 통과
	if($member['mb_level'] >= 8) {
		$cap_val = "admin";
		$cap_chk = 1;
	}

	if($char_subj || $char_cont || $a_tag_chk || $video_tag_chk || $embed_tag_chk || $img_tag_chk || $a_tag_attr_chk) {
		
		$filter_value = "";

		if($char_subj) {
			$filter_value .= "제목특수문자,";
		}
		if($char_cont) {
			$filter_value .= "내용특수문자,";
		}
		if($a_tag_chk) {
			$filter_value .= "a태그초과,";
		}
		if($video_tag_chk) {
			$filter_value .= "video태그사용,";
		}
		if($embed_tag_chk) {
			$filter_value .= "embed태그사용,";
		}
		if($img_tag_chk) {
			$filter_value .= "img태그변형,";
		}
		if($a_tag_attr_chk) {
			$filter_value .= "a태그변형,";
		}

		$filter_value = rtrim($filter_value, ",");

		$sql = " insert into {$g5['spam_log_table']}
					set sl_bo_table = '$bo_table',
						sl_filter = '".$filter_value."',
						sl_words = '".$char_data."',
						sl_confirm = '등록실패',
						sl_before_site = '".get_session('referer_set_url')."',
						sl_now_site = '{$_SERVER['HTTP_REFERER']}',
						sl_content_type = '{$_SERVER['CONTENT_TYPE']}',
						sl_script_filename = '{$_SERVER['SCRIPT_FILENAME']}',
						sl_before_ip = '".get_session('remote_set_ip')."',
						sl_now_ip = '{$_SERVER['REMOTE_ADDR']}',
						sl_captcha = '".$cap_val."',
						sl_captcha_chk = '".$cap_chk."',
						sl_token = '{$_POST['token']}',
						sl_typing = '".$_POST['real_typing']."',
						sl_browser = '".@getBrowser2()."',
						sl_device = '".@MobileCheck2()."',
						sl_os = '".@getOS2()."',
						sl_staytime = '$wr_num',
						sl_date = '".G5_TIME_YMD."',
						sl_time = '".G5_TIME_HIS."',
						sl_datetime = '".G5_TIME_YMDHIS."',
						sl_block_day = '".G5_TIME_YMD."',
						bo_table = '$bo_table',
						wr_id = '$wr_id',
						wr_num = '$wr_num',
						mb_id = '{$member['mb_id']}',
						mb_name = '{$member['mb_name']}',
						wr_name = '".$wr_name."',
						wr_password = '$wr_password',
						wr_option = '$html,$secret,$mail',
						wr_email = '$wr_email',
						wr_subject = '$wr_subject',
						wr_content = '$wr_content',
						wr_datetime = '".G5_TIME_YMDHIS."',
						wr_ip = '{$_SERVER['REMOTE_ADDR']}',
						wr_1 = '$wr_1',
						wr_2 = '$wr_2'";
		sql_query($sql);
		$sl_idx = sql_insert_id();
	
		
		// 아이피차단 제외 체크
		$company_ip_arr = array("210.217.10.63", "119.207.79.+"); // 아이피차단에서 제외할 아이피 등록 
		
		$is_intercept_ip_cnt = 0;

		for ($i=0; $i<count($company_ip_arr); $i++) {
			$company_ip_arr[$i] = trim($company_ip_arr[$i]);
			$company_ip_arr[$i] = str_replace(".", "\.", $company_ip_arr[$i]);
			$company_ip_arr[$i] = str_replace("+", "[0-9\.]+", $company_ip_arr[$i]);
			$pat = "/^{$company_ip_arr[$i]}$/";
			$is_ipt_ip = preg_match($pat, $_SERVER['REMOTE_ADDR']);
			if($is_ipt_ip) {
				$is_intercept_ip_cnt++;
			}
		}


		// 캡챠 체크값이 없으면 스팸으로 간주
		if($member['mb_level'] < 8 && $cap_chk == "") { // 관리 권한 없는 회원 또는 비회원만 적용
			
			if($is_intercept_ip_cnt == 0) {
				$intercept_ip_pattern = $config['cf_intercept_ip'];
				$intercept_ip_add = trim($intercept_ip_pattern)."\n".trim($_SERVER['REMOTE_ADDR']);

				// 스팸으로 간주하고 아이피 차단에 추가 (스팸으로 예상되는 아이피 차단 기능을 사용하지 않으려면 쿼리부분 주석처리 해주세요)
				$sql = " update {$g5['config_table']}
					set 
						cf_intercept_ip = '".trim($intercept_ip_add)."'";
				sql_query($sql);
				
				// ip 차단 날짜 등록
				sql_query(" update {$g5['spam_log_table']} set sl_block_day = '".G5_TIME_YMD."' where sl_idx = '$sl_idx' ");
			}


			$row_mem = sql_fetch("select mb_no, mb_id from {$g5['member_table']} where mb_id = '{$member['mb_id']}'");

			// 회원가입되어있으면 탈퇴처리 (스팸으로 예상되는 아이디 삭제 기능을 사용하지 않으려면 쿼리부분 주석처리 해주세요)
			if($row_mem['mb_id'] == $member['mb_id']) {
				
				// 회원 삭제처리 
				member_delete($row_mem['mb_id']);
				
				// 메모 추가
				$sql = "update {$g5['member_table']}
								set
									mb_memo = '\n스팸 글 작성으로 인한 삭제'
							where mb_id = '{$row_mem['mb_id'] }' ";
				sql_query($sql);
				
				// 강제 로그인 해제
				// 이호경님 제안 코드
				session_unset(); // 모든 세션변수를 언레지스터 시켜줌
				session_destroy(); // 세션해제함

				// 자동로그인 해제 --------------------------------
				set_cookie('ck_mb_id', '', 0);
				set_cookie('ck_auto', '', 0);
				// 자동로그인 해제 end --------------------------------

			}
		}


		alert('부적절 한 단어가 사용 되었습니다.');
		die();
	}

}
?>