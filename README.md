Ceci est le fichier README.TXT pour la distribution courante de SIGES

SIGES est diffusé suivant les termes de la Licence Publique Générale GNU (GPL) version 2.0.

Pour toute question ou commentaire sur cette application, vous pouvez contacter les développeurs du projet:

LOGIPAM (info@logipam.com)
Jean Bapstiste Marc (jbmarc@logipam.com)
Metuschael Prosper (mprosper@logipam.com)
Jean Eder Hilaire (jehilaire@logipam.com)
Jean Came Poulard (jcpoulard@logipam.com)

Comment installer SIGES 
SIGES requiert que votre ordinateur a un serveur web installe, sous windows wamp est conseille, sous MACOS MAMP et sous LINUX apache/MySQL

1) Transferer le repertoire SIGES sur votre repertoire racine web (Wamp : dans le www - Linux/Ubuntu : /var/www/html/)
2) Generer la base de donnees de SIGES en important le fichier siges.sql  en utilisant PhpMyAdmin ou MySQLDump
3) Ouvrir le fichier /siges/protected/config/db.php 
4) Modifier les noms de la base de donnes, le nom d'utilisateur et le mot de passe (dbname, username, password) 
    pour wamp : utiliser usernme=root et laisser le mot de passe vide. 
5)Ouvrir chrome ou Firefox a l'adresse : localhost/siges/ 
6) Loger avec l'authentification : nom utilisateur : admin et mot de passe : admin


