#dict : 사전 자료형

dic = {}
dic['dictionary'] = '1. A reference book containing an ...'
dic['python'] = 'Any of various nonvenomous snakes of the ...'
print(dic['dictionary'])

#key and value
samlldic = {'dictionary' : 'reference', 'python': 'snake'}
print(samlldic['python'])
del samlldic['python']
print(samlldic)

#key and value ex

family = {'boy':'choi', 'girl':'kim', 'baby':'choi'}
print(family)             # 값을 넣는 순서대로 저장되지는 않음.
print(family.keys())      # 사전 family의 key들을 새로운 리스트에 담는다.
print(family.values())    # 사전 family의 값들을 새로운 리스트에 담는다.

print('boy' in family)
print('sister' in family)



