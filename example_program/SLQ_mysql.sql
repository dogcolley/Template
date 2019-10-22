
--SELECT        : 조회
--FROM          : 대상
--ORDER BY      : 정렬
--GROUP BY      : 구릅정렬
--DESC          : 내림차순
--ASC           : 오른차순
--COUNT         : 카운트
--AS COUNT      : 수정렬
--UNION         : 합집합 중복미포함
--UNION ALL     : 합집합 중복포함
--INTERSECT     : 교집합
--MINUS         : 차집합
--DELECT        : 삭제
--UPDATE        : 수정
--CREATE        : 생성
--INSERT        : 

/*
--주요구문 

1. CREATE DATABASE / CREATE TABLE
: 생성을 의미합니다.
ex) CREATE DATABASE , CREATE TALBE
-선택은 USE
-TABLE 생성시 제약조건
    a. NOT NULL : 해당 필드는 NULL 값을 저장할 수 없게 됩니다.
    b. UNIQUE : 해당 필드는 서로 다른 값을 가져야만 합니다.
    c. PRIMARY KEY : 해당 필드가 NOT NULL과 UNIQUE 제약 조건의 특징을 모두 가지게 됩니다.
    d. FOREIGN KEY : 하나의 테이블을 다른 테이블에 의존하게 만듭니다.
    e. DEFAULT : 해당 필드의 기본값을 설정합니다.
ex) 생성예제
    CREATE TABLE Test

    (

        ID INT,

        Name VARCHAR(30),

        ReserveDate DATE,

        RoomNum INT

    );

2. ALTER DATABASE / ALTER TABLE
:ALTER 문을 사용하여 데이터베이스와 테이블의 내용을 수정할 수 있습니다.
ex) ALTER DATABASE , ALTER TABLE
-문법
ex) a. ALTER DATABASE 데이터베이스이름 CHARACTER SET=문자집합이름
    b. ALTER DATABASE 데이터베이스이름 COLLATE=콜레이션이름
-대표적인 COLLATE
    a. utf8_bin
    b. utf8_general_ci (기본 설정)
    c. euckr_bin
    d. euckr_korean_ci
-대표적인 CHARACTER SET 
    a. utf8 : UTF-8 유니코드를 지원하는 문자셋 (1~3바이트)
    b. euckr : 한글을 지원하는 문자셋 (1~2바이트)
-수정
    a. ADD [필드추가] ALTER TABLE 테이블이름 ADD 필드이름 필드타입 
        ex)ALTER TABLE Reservation ADD Phone INT;
    b. DROP [필드삭제] ALTER TABLE 테이블이름 DROP 필드이름 
        ex)ALTER TABLE Reservation DROP RoomNum;
    c. MODIFY COLUMN [필드타입변경]ALTER TABLE 테이블이름 MODIFY COLUMN 필드이름 필드타입
        ex)ALTER TABLE Reservation MODIFY COLUMN ReserveDate VARCHAR(20);

5. DROP TABLE / DROP DATABASE
: 데이터 베이스 삭제
ex)DROP DATABASE 데이터베이스이름

6. INSERT INTO
: MySQL에서는 INSERT INTO 문을 사용하여 테이블에 새로운 레코드를 추가할 수 있습니다.
ex)
    1. INSERT INTO 테이블이름(필드이름1, 필드이름2, 필드이름3, ...)
    VALUES (데이터값1, 데이터값2, 데이터값3, ...)
    2. INSERT INTO 테이블이름
    VALUES (데이터값1, 데이터값2, 데이터값3, ...)
ex)
    INSERT INTO Reservation(ID, Name, ReserveDate, RoomNum)
    VALUES(5, '이순신', '2016-02-16', 1108);

7. UPDATE
: MySQL에서는 UPDATE 문을 사용하여 레코드의 내용을 수정할 수 있습니다.
ex)
    UPDATE 테이블이름
    SET 필드이름1=데이터값1, 필드이름2=데이터값2, ...
    WHERE 필드이름=데이터값
ex)
    UPDATE Reservation
    SET RoomNum = 2002
    WHERE Name = '홍길동';

8. DELETE
: 테이블 삭제기능
ex)
    DELETE FROM 테이블이름
    WHERE 필드이름=데이터값
ex)
    DELETE FROM 테이블이름;
ex)
    DELETE FROM Reservation
    WHERE Name = '홍길동';

9. 숫자타입
    1. 정수 타입(integer types)
    2. 고정 소수점 타입(fixed-point types)
    3. 부동 소수점 타입(floating-point types)
    4. 비트값 타입(bit-value type)

타입	    저장 공간	    최댓값	                                     최솟값
                           [Signed                 Unsigned]           [Signed              Unsigned]
TINYINT	    1바이트	        -128 	                0               	127	                255
SMALLINT	2바이트	        -32768          	    0               	32767	            65535
MEDIUMINT	3바이트	        -8388608            	0	                8388607         	16777215
INT	        4바이트	        -2147483648	            0	                2147483647	        4294967295
BIGINT	    8바이트	        -9223372036854775808 	0	                9223372036854775807	18446744073709551615


10.이외 특수 명령어
    union all : select문을 합칩니다. 단 컬럼수가 같아야합니다.

Explain을 사용해서 쿼리 최적화 하기

처음엔 이거이거 개발해! 이러면 API 만들고 결과 나오는 쿼리 그냥 넣고 결과 나오면 됐다!
이랬는데 ... 이제는 쿼리를 짤때 성능까지 생각해야 하며, 대충 결과만 나오던 쿼리는 나중에 문제가 되어
유지보수로 해야할 일이 되더라구요.
그러니 미리미리 성능을 고려하여 쿼리를 최적화 하는 습관을 길러야 합니다. 좋은 습관은 공유해야지요~  ^^

* 사용방법
	EXPLAIN[EXTENDEL] SELECT * FROM TB_COMMENT;

	쿼리 앞에 EXPLAIN 을 붙이기만 하면 쿼리에서 어떤 테이블을 쓰고 있는지 SELECT가 빠르게 잘 되는지 조인 여부 등 다양한 것들에 대해서 알 수 있고 쿼리 분석을 하는데 도움이 된다.

	id : SELECT IDENTIFIER. 쿼리 안에 순번같은 것이다.

	select_type : SELECT에 대한 타입
	 Select Type의 종류 SIMPLE : 단순 select을 말함. (union 또는 subquery 사용 안 함) Primary : 가장 외곽의 select UNION : Union에서 두 번째 혹은 나중에 따라오는 select Dependent Union : UNION 중 외곽쿼리에 의존적인 쿼리 Union result : Union의 결과물 Subquery : 서브 쿼리의 첫 번째 select Dependent Subquery : subquery 중 외곽쿼리에 의존적인 쿼리 Derived : Select로 추출된 테이블 즉, from절 내부의 쿼리

	table : 결과 열이 참조하는 테이블

	type : 조인에 대한 타입

	 Type의 종류 Const : 하나의 행만 매치함. Eq_ref : 조인 수행을 위해 각 테이블에서 하나씩의 행만 읽음 Ref : 조인 수행 시 매치되는 인덱스의 모든 행을 읽음 Ref_or_null : Ref + Null 값 포함 Range : 인덱스를 사용하여 주어진 범위 내의 행들만 추출 Index : Index 전체 스캔 All : 전체 테이블 스캔
	possible_keys : 이 테이블에서 열을 찾기 위해 MySQL이 선택한 인덱스를 가리킨다.
	이 컬럼은 EXPLAIN 결과에서 나타나는 테이블 순서와는 전적으로 별개의 순서가 된다.
	이것은, possible_keys에 있는 키 중에 어떤 것들은 테이블 순서를 만드는 과정에서는 사용되지 않을 수도 있음을 의미하는 것이다.
	만일 이 컬럼 값이 NULL이라면, 연관된 인덱스가 존재하지 않게 된다.
	이와 같은 경우, WHERE 구문을 검사해서, 이 구문이 인덱스 하기에 적당한 컬럼을 참조하고 있는지 여부를 알아 봄으로써 쿼리 속도를 개선 시킬 수가 있게 된다.
	그러한 경우라면, 적절한 인덱스를 하나 생성한 후에, EXPLAIN를 다시 사용해서 쿼리를 검사한다.
	(솔직히 100% 이해가 되지 않는다. 그래서 참조한 곳에서 그대로 가져옴.)

	key : 실제로 사용할 예정인 키 (인덱스)

	key_len : MySQL이 사용하기로 결정한 키의 길이

	ref : 테이블에서 열을 선택하기 위해 key 컬럼 안에 명명되어 있는 인덱스를 어떤 컬럼 또는 상수(constant)와 비교하는지 보여줌.

	rows : MySQL이 쿼리를 실행하기 위해 조사해야 하는 열의 숫자를 가리킴.

	Extra : 쿼리 실행 시 필요한 추가적인 정보를 제공. 성능 개선에 필요한 주요 정보 컬럼

	 Using filesort Using index Using temporary Using index for group-by - Group by 시 index를 이용하여 값을 추출 함. Using where Using join cache Select tables optimized away – 인덱스를 사용하여 group by 없이 집단함수 값을 추출하는 경우



explain : tk
*/



-- 테이블 전체 조회
SELECT * FORM ANIMAL_INS

-- 역순 정렬
SELECT NAME, DATETIME 
FROM ANIMAL_INS 
ORDER BY ANIMAL_ID DESC

-- 아픈 동물찾기
SELECT ANIMAL_ID,NAME
FROM ANIMAL_INS
WHERE INTAKE_CONDITION = 'Sick'
ORDER BY ANIMAL_ID

-- 어린동물 찾기 
SELECT ANIMAL_ID,NAME
FROM ANIMAL_INS
WHERE INTAKE_CONDITION !='Aged' 
ORDER BY ANIMAL_ID

-- 최소값 구하기
SELECT DATETIME 
FROM ANIMAL_INS 
ORDER BY DATETIME LIMIT 1

-- NULL 값 구하기
SELECT ANIMAL_INS
FROM ANIMAL_INS
WHERE NAME IS NULL

-- 카운터 문
SELECT, COUNT(ANIMAL_TYPE) AS COUNT 
FROM ANIMAL_INS GROUP BY ANIMAL_TYPE 

-- 카운터 조건문
SELECT NAME, COUNT(NAME) AS COUNT
FROM  ANIMAL_INS 
GROUP BY NAME HAVING COUNT(NAME) >= 2 

-- 없어진 기록찾기 (두 테이블을 조인하고 비교)
SELECT A.ANIMAL_ID , A.NAME 
FROM ANIMAL_OUTS A LEFT JOIN ANIMAL_INS B 
ON A.ANIMAL_ID = B.ANIMAL_ID 
WHERE B.ANIMAL_ID IS NULL
ORDER BY A.ANIMAL_ID

--잘못된 입력된 구조 INPUT OUTPUT 테이블 불러와서 매칭비교연산후에 처리
SELECT ED1.ANIMAL_ID, ED1.NAME
FROM (
    SELECT A.ANIMAL_ID, A.NAME, A.DATETIME AS ATIME, B.DATETIME AS BTIME 
    FROM ANIMAL_INS A, ANIMAL_OUTS B
    WHERE A.ANIMAL_ID = B.ANIMAL_ID
    ) ED1
WHERE ED1.ATIME > ED1.BTIME
ORDER BY ED1.ATIME

-- 날짜가 입출이 잘못 입력된 DATA출력
SELECT A.NAME, A.DATETIME
FROM ANIMAL_INS A LEFT JOIN
ANIMAL_OUTS B ON A.ANIMAL_ID = B.ANIMAL_ID
WHERE B.ANIMAL_ID IS NULL
ORDER BY A.DATETIME
LIMIT 3


