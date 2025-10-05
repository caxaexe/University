def truth_table():
    print("-----------------------------------------------------------------")
    print(" x | y | z | (x->y) | ((x->y)↓z) | ¬(x->y)  | ((x->y)∨z)|¬(x->y)")
    print("-----------------------------------------------------------------")
    all_zero = True
    all_one = True
    last_value = None
    first_value = None
    increasing = True
    for x in [False, True]:
        for y in [False, True]:
            for z in [False, True]:
                x_implicatia_y = y if x else True
                implicatia_result = x_implicatia_y 
                
                implicatia_strelkasheffera_z = not(implicatia_result or z)
                
                not_implicatia_result = not implicatia_result
                
                final_result = not(implicatia_strelkasheffera_z and not_implicatia_result)
                
                print(f" {int(x)} | {int(y)} | {int(z)} |   {int(x_implicatia_y)}    |     {int(implicatia_strelkasheffera_z)}      |     {int(not_implicatia_result)}    |         {int(final_result)}")
                
                if final_result != 0:
                    all_zero = False
                if final_result != 1:
                    all_one = False
                    
                if last_value is not None and final_result <= last_value:
                    increasing = False
                    
                last_value = final_result
                
                if first_value is None:
                    first_value = final_result
    print("-----------------------------------------------------------------")
    
    if all_zero:
        print("Переменные x, y и z фиктивные")
    elif all_one:
        print("Переменные x, y и z фиктивные")
    else:
        print("Переменные x, y и z существенные")
    print("-----------------------------------------------------------------")
    
    if first_value == 0:
        print("Функция принадлежит классу T0")
    elif first_value == 1:
        print("Функция не принадлежит классу T0")
        
    if last_value == 0:
        print("Функция не принадлежит классу T1")
    elif last_value == 1:
        print("Функция принадлежит классу T1")
    
    
    if increasing:
        print("Функция принадлежит классу M")
    else:
        print("Функция не принадлежит классу M")

truth_table()
