
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
-- 코드를 입력하세요
SELECT ED1.ANIMAL_ID, ED1.NAME
FROM (
    SELECT A.ANIMAL_ID, A.NAME, A.DATETIME AS ATIME, B.DATETIME AS BTIME 
    FROM ANIMAL_INS A, ANIMAL_OUTS B
    WHERE A.ANIMAL_ID = B.ANIMAL_ID
    ) ED1
WHERE ED1.ATIME > ED1.BTIME
ORDER BY ED1.ATIME