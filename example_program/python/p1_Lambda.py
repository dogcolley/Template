# lambda 인자 : 표현식
def hap(x,y):
		return x + y

print(hap(10,20))

print((lambda x,y: x + y)(10,20))

#map 함수와 리스트 인자
x = map(lambda x: x **2, range(5))
y = list(map(lambda x: x **2, range(5)))

print(x,'\n')
print(y,'\n')

#reduce (함수, 순서형 자료)

from functools import reduce
z = reduce(lambda x,y: x+y, [0,1,2,3,4])

print(z)

a = reduce(lambda x, y: y + x, 'abcde')

print(a)

#filter (함수 , 리스트)
b = filter(lambda x:x < 5 , range(10))
c = list(filter(lambda x:x < 5 , range(10)))

print(b)
print(c)

d = filter(lambda x: x % 2, range(10))        # 파이썬 2
f = list(filter(lambda x: x % 2, range(10)))  # 파이썬 2 및 파이썬 3

print(d)
print(f)