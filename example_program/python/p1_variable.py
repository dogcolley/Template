def d_is_10():
	d = 10 
	return d

#이런식으로 지역변수를 주면 사라집니다.
#값을 리턴으로 반환

def c_is_20():
	global c 
	c = 20 
	print ('c 값은', c, '입니다')

#글로벌 변수로 설정해줘서 사라지지 않겠다고 명시한다.



x = 10
def printx():
	print (x)

y= d_is_10()


#printx()
#d_is_10()
#c_is_20()
