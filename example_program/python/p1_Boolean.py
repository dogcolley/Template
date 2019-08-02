#what boolean

a = (1 + 1 ==2)

print(a)

b = (1 + 1 ==3)

print(b)

#if boolean
if b : 
	print('yes')
else:
	print('no')

#function 

def exam():
	ans = raw_input('1 + 2 = ')
	return 1 + 2 == int(ans)

exam()