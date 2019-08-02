import math
#import numpy as np

computer = ['com-a','com-b']
progarm_time = [3,5,2]

def prg2com(supply, consumption):
	
	#setting program
	a_total = 0
	b_total = 0
	c_total = 0
	num1 = 0  
	num2 = 0  

	supply_c = list()
	consumption_c = list()

	for j in supply:
		b_total += 1
	
	while num1 < b_total:
		supply_c.append(num1)
		num1 += 1

	for i in consumption:
		a_total += i
		c_total += 1
		consumption_c.append(0)


	m_t_c = math.ceil(a_total / b_total)

	print('total_time["progarm"]:',a_total)
	print('total_num["progarm"]:',c_total)
	print('total_num["computer"]:',b_total)
	print('move_total_tile["computer"]:',m_t_c)
	print('computer now counter:',supply_c)
	print('progarm now counter:',consumption_c)
	
	while num2 < m_t_c:
		m_time = num2 + 1
		print('Dispose of....time : ',m_time)
		for k in supply_c:
			print('[Num',k,']test: supply_computer moving for progarm[',k,']')
			if consumption_c[k] < consumption[k] :
				consumption_c[k] += 1
			#else :


		num2 += 1
	#rooting program
	#print program

prg2com(computer , progarm_time)