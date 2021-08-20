#! /usr/bin/env python
# -*- coding: utf-8 -*-
#   Gter Copyleft 2018
#   Roberto Marzocchi


import os, sys

import psycopg2
from credenziali import *

con = psycopg2.connect(host=ip,dbname=db, user=user, password=pwd, port=port)
cur = con.cursor()
con.autocommit = True

#import csv
#open('[path/filename.extension]', '[r OR w]') AS f_output


#schemi=['eventop','eventop','eventop','eventol']
#tabelle=['t_concessioni', 't_pubbblicita', 'r_pubblicita','t_concessioni']

schemi=['eventop','eventop','eventop','eventop']
tabelle=['t_con_pubblicita', 'r_conpub_mod', 'r_conpub_anagditte','r_conpub_anagrichiedenti']



i=0
while i < len(schemi):
    #query per concessioni
    query="""select column_name,column_default, data_type, is_nullable 
    character_maximum_length, numeric_precision
    from information_schema.columns 
    WHERE table_schema='{}' and table_name='{}'""".format(schemi[i], tabelle[i])
    #print(query)
    #print(schemi[i][6])
    print ('Esporto il CSV - {}'.format(tabelle[i]))
    '''
    with open('{}_{}.csv'.format(tabelle[i],schemi[i][6]), mode='w') as efile:
        e_writer = csv.writer(efile, delimiter=',', quotechar='"', quoting=csv.QUOTE_MINIMAL)
        e_writer.writerow(['column_name','column_default', 'data_type', 'is_nullable', 'character_maximum_length', 'numeric_precision'])
        cur.execute(query)
        campi=cur.fetchall()
        for cc in campi:
            e_writer.writerow(cc)
    '''
    # Use the COPY function on the SQL we created above.
    SQL_for_file_output = "COPY ({0}) TO STDOUT WITH CSV HEADER".format(query)

    # Set up a variable to store our file path and name.
    t_path_n_file = '{}_{}.csv'.format(tabelle[i],schemi[i][6])
    with open(t_path_n_file, 'w') as f_output:
        cur.copy_expert(SQL_for_file_output, f_output)
    i+=1


# impostare un webservice get_codifica.php?t=nome_tabella&c=nome_campo che restituisca un json 
# con la decodifica che si metterà a disposizione pubblicamente
# https://catastostrade.provincia.pc.it/query/get_decodifica.php?t=areatraffico&c=tipo
# da togliere il d_

# d_lato #subquery

# d_ e != d_lato fai subquery dentro normativa
# impostare un webservice get_XXXX.php?t=nome_tabella che restituisca un json con la decodifica


# fk ???

# lista concessionari??
