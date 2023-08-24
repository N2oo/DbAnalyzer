import mysql.connector
import re

mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    passwd="root",
    database="dbanalyzer",
    port="3307")

mycursor = mydb.cursor()

def addSpacesOnQuery(query):
    query = query.replace('select', ' select ')
    query = query.replace('from', ' from ')
    query = query.replace('where', ' where ')
    query = query.replace('group by', ' group by ')
    return query

def analyzeQuery(sqlQuery):
    sqlQuery = addSpacesOnQuery(sqlQuery)
    sqlQueryCreate = re.sub(r'as select.*', '', sqlQuery).strip()
    sqlQueryCreate = re.search(r'\((.*?)\)', sqlQueryCreate).group(1).strip().replace('"', '').replace("credel.","")

    sqlQuerySelect = re.search(r'select\s+(.*?)\s+from', sqlQuery).group(1).strip().replace('"', '').replace("credel.","")

    #gestion des virgules dans les parenthèses
    # pattern = r'\(([^)]*)\)'
    pattern = r'[\(\[]([^)\]]*)[\)\]]'
    replacement = lambda match: match.group(0).replace(',', '#')
    sqlQuerySelect = re.sub(pattern, replacement, sqlQuerySelect)



    sqlQueryFrom = re.search(r'from(.*)where', sqlQuery)
    if(sqlQueryFrom is None):
        sqlQueryFrom = re.search(r'from(.*)group by', sqlQuery)
        if sqlQueryFrom is None:
            sqlQueryFrom = re.search(r'from(.*)#', sqlQuery)

    sqlQueryFrom = sqlQueryFrom.group(1).strip().replace('"', '').replace("credel.","")

    # mise en place des différents tableaux à partir des portions de requêtes
    viewFields = [x.strip() for x in sqlQueryCreate.split(',')]
    selectFields = [x.strip().replace('#',",") for x in sqlQuerySelect.split(',')]
    fromFields = [x.strip() for x in sqlQueryFrom.split(',')]

    # gestion des champs issus d'une fonction
    for key,selectField in enumerate(selectFields):
        #permet de ne récupérer que l'élément sans se soucier des fonctions etc...
        pattern = r'x\d+\S*'
        finds = re.findall(pattern, selectField)
        # si on en a strictement 1 résultat, alors on remplace par le nom du champ, si plus de matchs que 1 => le champs est une référence à de multiples champs
        if len(finds) == 1:
            selectFields[key] = finds[0].replace(')','').replace('(','')


    tables = {key: value for key, value in zip(viewFields, selectFields)}

    fieldAssoc = {}
    for item in fromFields:
        match = re.search(r'(\w+)\s*(x\d+)', item)
        if match:
            value, key = match.groups()
            fieldAssoc[key] = value
    return tables, fieldAssoc

sql = "select f.id from `field` f left join `table` t on f.for_table_id = t.id where t.name = '{}' and f.name ='{}'"
sql_update = "update `field` f set use_property_id = {} where id = {}"

mycursor.execute("SELECT query,name,for_db_id FROM `table` t where t.is_view = 1")
for line in mycursor.fetchall():
    table_name = line[1]
    tables, fieldAssoc = analyzeQuery(line[0])
    # if table_name == 'vcc_client':
    #     print(tables)
    #     print(fieldAssoc)
    #     exit()
    for key, value in tables.items():

        #si on a trop de x, c'est que le champ est composé de plusieurs autres champs on passe à la suite.
        pattern = r'x\d+\S*'
        regularExpr = re.findall(pattern, value)
        nbr = len(regularExpr)
        if nbr != 1:
            continue

        x_label = value.split('.')[0]
        tab = fieldAssoc[x_label]

        field_label = value.split('.')[1]
        mycursor.execute(sql.format(tab,field_label))
        
        id_of_folowed_field = None
        for line2 in mycursor:
            id_of_folowed_field = line2[0]
        id_of_field_to_update = None
        mycursor.execute(sql.format(table_name,key))
        for line2 in mycursor:
            id_of_field_to_update = line2[0]
        mycursor.execute(sql_update.format(id_of_folowed_field,id_of_field_to_update))
        # try:
        #     mycursor.execute(sql_update.format(id_of_folowed_field,id_of_field_to_update))
        # except Exception as e:
        #     print("ERREUR sur la table {} et le champ {}".format(table_name,key))
        #     print("id_of_folowed_field : {}, id_of_field_to_update : {}".format(id_of_folowed_field,id_of_field_to_update))
        #     print(tables)
        #     print(fieldAssoc)
        #     print('-'*10)
        #     exit()
        mydb.commit()

mycursor.close()
