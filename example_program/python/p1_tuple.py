a = 10
b = 20
temp = a #temp 10
a = b  # a 20 
b = temp #b 10

print(a,b)

c = 10
d = 20
c,d = d,c 
print(c,d)

def magu_print(x,y,*rest):
	print (x, y, rest)
magu_print(1,2,3,4,5,6,7,8,9,10)

#empty = ()

empty = ()

p = (1,2,3)
q = (p[:1] + (5,)+ p[2:])
print(q)
r =  p[:1] , 5, p[2:]
print(r)