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

    pattern = r'\(([^)]*)\)'
    replacement = lambda match: match.group(0).replace(',', '#')
    sqlQuerySelect = re.sub(pattern, replacement, sqlQuerySelect)


    sqlQueryFrom = re.search(r'from(.*)where', sqlQuery)
    if(sqlQueryFrom is None):
        sqlQueryFrom = re.search(r'from(.*)group by', sqlQuery)
        if sqlQueryFrom is None:
            sqlQueryFrom = re.search(r'from(.*)#', sqlQuery)
    # else:
    #     sqlQueryFrom = sqlQueryFrom.group(1).strip().replace('"', '').replace("credel.","")
    sqlQueryFrom = sqlQueryFrom.group(1).strip().replace('"', '').replace("credel.","")

    viewFields = [x.strip() for x in sqlQueryCreate.split(',')]
    selectFields = [x.strip().replace('#',",") for x in sqlQuerySelect.split(',')]
    fromFields = [x.strip() for x in sqlQueryFrom.split(',')]

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
    for key, value in tables.items():
        x_label = value.split('.')[0]
        try:
            field_label = value.split('.')[1]
            mycursor.execute(sql.format(fieldAssoc[x_label],field_label))
            id_of_folowed_field = None
            for line2 in mycursor:
                id_of_folowed_field = line2[0]
            id_of_field_to_update = None
            mycursor.execute(sql.format(table_name,key))
            for line2 in mycursor:
                id_of_field_to_update = line2[0]
            mycursor.execute(sql_update.format(id_of_folowed_field,id_of_field_to_update))
            mydb.commit()
        except:
            pass

mycursor.close()
