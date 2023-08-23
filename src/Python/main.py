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


mycursor.execute("SELECT query,name,for_db_id FROM `table` t where t.is_view = 1")
for x in mycursor:
    print(x[1])
    print(analyzeQuery(x[0]))

mycursor.close()
