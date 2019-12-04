/*
	일반 브라우저에서 사용시 IE를 위해 link src 바벨을 꼭 사용해주길 권장드립니다.
	use babel js plase;

	탈 제이쿼리를 위한 직접 제작한 모듈 사용입니다. ES6 이상의 베이스 적용을 목적을 하고있습니다. 

	01 . window 
	window.close()
	window.open()
	window.encodeURI(), window.decodeURI()
	window.setTimeout(함수, 밀리초), window.setInterval(함수, 밀리초)

	02. navigator
	navigator.userAgent; // user divce data
	navigator.language; // "ko"
	navigator.cookieEnabled; // true
	navigator.vendor; // "Google Inc"

	03. screen
	screen.availHeight; // 1080
	screen.availWidth; // 1920
	screen.colorDepth; // 24

	04. location
	location.host; // "www.zerocho.com"
	location.hostname; // "www.zerocho.com"
	location.protocol; // "https:"
	location.href; // "https://www.zerocho.com/category/Javascript/post/..."
	location.pathname; // "/category/Javascript/post/..."

	05.document
	document.getElementById(아이디)
	document.getElementsByClassName(클래스)
	document.getElementsByName(이름)
	document.getElementsByTagName(태그)
	document.querySelector(선택자)
	document.querySelectorAll(선택자)
	document.createElement(태그명)
	document.createTextNode(텍스트)
	document.createDocumentFragment() // 가상돔 생성방식 여기서 미리 만들고 한번에 뿌려주면 성능면에서 엄청 좋다
	
	document.head
	document.body
	document.anchors
	document.links
	document.forms
	document.images
	document.scripts
	document.title

	06 속성 모음 
	태그.nodeType (해당태그의 정보호출)
	(Node.ELEMENT_NODE) -> Element 
	(Node.TEXT_NODE) -> 텍스트 
	(Node.COMMENT_NODE) -> 주석 
	(Node.DOCUMENT_NODE) -> Document
	(Node.DOCUMENT_TYPE_NODE) -> DOCTYPE 
	(Node.DOCUMENT_FRAGMENT_NODE) -> Document Fragment 

	태그.children(텍스트 노드 제외)
	태그.childNodes(텍스트 노드 포함)
	ex)document.body.children; // [header, main, footer, script]
	
	태그.firstChild 
	태그.firstElementChild
	태그.lastChild
	태그.lastElementChild
	ex)document.body.firstChild; // <header>...</header>
	ex)document.body.lastchild; // <script>...</script>

	태그.parentNode
	태그.parentElement
	ex)document.body.parentNode; // <html>...</html>

	태그.previousSibling
	태그.nextSibling
	태그.previousElementSibling
	태그.nextElementSibling
	ex)document.getElementsByTagName('main')[0].nextSibling; // <footer></footer>

	태그.innerHTML
	태그.outerHTML
	ex)var footer = document.getElementsByTagName('footer')[0];
	ex)footer.innerHTML; // 'hello'
	ex)footer.innerHTML = 'goodbye';
	
	태그.속성
	ex)var tag = document.getElementById('header');
	ex)tag.id; // 'header'
	태그.attributes(해당 태그가 가진 모든 속성을 보고싶다면 attributes 속성을 사용하면 됩니다. )
	태그.clientHeight, 태그.clientWidth(태그의 margin, border, scrollbar을 제외한 높이와 너비를 반환합니다.)
	태그.offsetHeight, 태그.offsetWidth(태그의 margin만 제외한 높이와 너비를 반환합니다.)
	태그.scrollHeight, 태그.scrollWidth(스크롤 가능한 범위까지 포함한 태그의 높이와 너비를 반환합니다.)

	07. 메소드 모음
	태그.appendChild (createElement()  함수로 만들었던 태그를 넣을 때 이 메소드가 필요합니다.  )
	ex) var newElement = document.createElement('div');
	ex) document.body.appendChild(newElement);
	태그.removeChild
	ex) document.body.removeChild(document.body.childNodes[document.body.childNodes.length - 1]);
	태그.insertBefore
	ex)var newElement = document.createElement('div');
	ex)document.body.insertBefore(newElement, document.getElementById('header'));
	태그.cloneNode(자신을 복사합니다.)
	ex)var clone = document.getElementsByTagName('nav')[0].cloneNode();
*/

const make_popup = (text,addDow) =>  {
	var popup = window.open('', '', 'width=200,height=200');
	popup.document.write(text);
}
//make_popup('test');

//cell .
const jsh_admin ={ 
	admin_use : false,
}

const use_user = 'jsh';

var list = [0,1,2,3,4,5,6,7,8,9];
var number = [];
for (var i = 0; i < 4; i++) {
  var select = Math.floor(Math.random() * list.length);
  console.log('list', list, 'number', number, 'length', list.length);
  number[i] = list.splice(select, 1)[0];
}


const jsh_alert = (text) => {
	alert(text);
}

jsh_alert('test');
console.log(jsh_admin.admin_use)