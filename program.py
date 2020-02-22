#!/usr/bin/python
import sys,filecmp,os,shutil,time
from glob import glob


# Lancer le serveur
#@route('/hello/bibi')
#def index(name):
#    return template('<b>Hello {{name}}</b>!', name=name)

#run(host='207.154.255.55', port=8080)



#placer les fichiers pythons dans /usr/lib/cgi-bin

def main():

    print "Content-type: text/html\n\n"
    print "<h1>Hello World</h1>"

    # les chemins des dossiers
    # SUR WINDOWS
    if os.name == 'nt':
        le_nom_du_projet = str(sys.argv[1])
        directory_path   = ".\source"
        destination_path = ".\compilateur"
        final_path       = ".\hex"
    # SUR LINUX
    else:
        le_nom_du_projet = "C4X_esclave"
        directory_path   = "/var/www/html/compilateur_sans_fil/source"
        destination_path = "/var/www/html/compilateur_sans_fil/compilateur"
        final_path       = "/var/www/html/compilateur_sans_fil/hex"

    print 'le_nom_du_projet:', le_nom_du_projet

    # le comparer aux dossiers presents dans /sources/*
    if get_name_projet( le_nom_du_projet , directory_path ) != True:
        le_nom_du_projet = ""
        print "/!\ Choissisez un nom de projet valide ! "
    else:
        directory_path += "/"
        directory_path += le_nom_du_projet
        print 'directory_path:', directory_path
        get_src( directory_path + "/src" , destination_path + "/src" )
        get_lib( directory_path + "/lib" , destination_path + "/libraries" )

        # Lancement de la compilation
        do_compilation( destination_path, final_path, le_nom_du_projet )


		
		
# Une fois le dossier trouve
# Le sauvegarder dans la variable le_nom_du_projet
def get_name_projet( name_projet , path ):
    for f in os.listdir( path ):
        if f == name_projet:
            le_nom_du_projet = f
            print "Vous avez choisi un projet existant, Le nom_du_projet est:", le_nom_du_projet
            return True

			
			
			
# Recuperer le fichier dans ../source/le_nom_du_projet/src/*.ino
# L envoyer dans ../compilateur/src/
# Remplacer l extension .ino par .pp
def get_src(cur_path, dest_path):
    print cur_path
    for root, dirs, files in os.walk(cur_path):
        for file in files:
            if file.endswith('.ino'):
                print file
                if os.path.isfile( dest_path +"/"+ "main.cpp" ):
                    os.remove(dest_path +"/"+ "main.cpp")
                shutil.copyfile(cur_path +"/"+ file, dest_path +"/"+ "main.cpp")

		

		
# Recupere tous les dossiers dans ../sources/le_nom_du_projet/lib/*
# Placer les dossiers dans ../compilateur/lib/*
def get_lib(cur_path, dest_path):
    print cur_path
    if os.path.isdir(dest_path):
        shutil.rmtree(dest_path, ignore_errors=False, onerror=None)
    shutil.copytree( cur_path, dest_path , symlinks=False, ignore=None)

	

def do_compilation(dest_path, final_path, new_hex_name):

    # supprimer les precedents fichiers .elf, .hex
    if os.path.isfile( dest_path +"/"+ "compilateur.elf" ):
        os.remove(dest_path +"/"+ "compilateur.elf")

    if os.path.isfile( dest_path +"/"+ "compilateur.hex" ):
        os.remove(dest_path +"/"+ "compilateur.hex")

    # lancer la commande make pour generer la compilation
    os.system("cd " + dest_path)
    os.system("make")

    for i in range(60):
        print "lancement du timer jusqua 60:", i
        time.sleep(1)    # seconds

        # Des qu on detecte la creation dun fichier compilateur.hex
        # Le renommer avec le_nom_du_projet  l envoyer vers ../../hex/*
        if os.path.isfile( dest_path +"/"+ "compilateur.hex" ):
            #suppression si il existe
            if os.path.isfile( final_path +"/"+ new_hex_name ):
                os.remove(final_path +"/"+ new_hex_name)
            # creation du nouveau
            shutil.copyfile( dest_path +"/"+ "compilateur.hex" , final_path +"/"+ new_hex_name)
            print "HEX FILE cree avec succes !"
            break

    # proposer de telecharger le hex file dans les fichiers locaux


if __name__ == '__main__':
 main()
