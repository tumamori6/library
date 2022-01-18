# -*- coding: utf-8 -*-
from __future__ import absolute_import
from __future__ import unicode_literals

class recommendClass:
    def __init__(self):
        import redis
        self.r = redis.Redis(host='localhost', port=6379, db=10)
    

    def calcJaccard(self,e1,e2):
        """
        :param e1: list of int
        :param e2: list of int
        :return: float
        """
        set_e1 = set(e1)
        set_e2 = set(e2)
        return float(len(set_e1 & set_e2)) / float(len(set_e1 | set_e2))
    

    def getKey(self,k):
        return 'JACCARD:PRODUCT:{}'.format(k)
    
    def setRating(self,products):
        """
        :pram products : str item_id : list of users_id
        """
        for key in products:
            base_customers = products[key]
            for key2 in products:
                if key == key2:
                    continue
                target_customers = products[key2]
                j = self.calcJaccard(base_customers,target_customers)
                self.r.zadd(self.getKey(key),{key2:j})

recommendClass = recommendClass();

#実際は各アイテムのセット数の上限を設ける
products = {
    'X': [1, 3, 5],
    'A': [2, 4, 5],
    'B': [1, 2, 3],
    'C': [2, 3, 4, 7],
    'D': [3],
    'E': [4, 6, 7],
}

recommendClass.setRating(products)
print recommendClass.r.zrevrange(recommendClass.getKey('A'),0,-1)
