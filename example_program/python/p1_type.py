a = 'a'
b = 6
c = 2.6
d = 3+4j
e = [1,2,3,4,5]

print(type(a))
print(type(b))
print(type(c))
print(type(d))
print(type(e))

print('=====================')

x = 'banana'
print(x[0])
print(x[2:4])
print(x[:3])
print(x[3:])

print('=====================')

prime = [2, 3, 7, 11]
prime[0] = 3 
prime.append( 5 )
print(prime)

print('=====================')

#2중 배열
matrix = [[1, 2, 3], [4, 5, 6], [7, 8, 9]]
print(matrix)

print('=====================')

characters = []
sentence = 'Be happy!'
for char in sentence:
		characters.append(char)
print(characters)

print('=====================')

chulsu = [90,85,70]
younghee = [88,79,92]
yong = [100,100,100]
minsu = [90,60,70]
students = [chulsu,younghee,yong,minsu]

for scores in students:
	total = 0
	for s in scores:
		total = total + s 
	average = total / 3
	print(scores, total, average)

