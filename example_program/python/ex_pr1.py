import math
#import numpy as np

computer = ['com-a','com-b']
progarm_time = [3,5,2]

def prg2com(supply, consumption):
	
	#setting program
	a_total = 0
	b_total = 0
	c_total = 0

	count_box = list()

	for j in supply:
		b_total += 1
		count_box.append(0)

	for i in consumption:
		a_total += i
		c_total += 1

	m_t_c = math.ceil(a_total / b_total)

	for k in count_box: 
		if k < m_t_c: 
			x =  k + progarm_time[0]  
			print(x)
		

	print('total_time["progarm"]:',a_total)
	print('total_num["progarm"]:',c_total)
	print('total_num["computer"]:',b_total)
	print('move_total_time["computer"]:',m_t_c)


prg2com(computer , progarm_time)