#!/bin/bash

# container stop
function containersStop
{
	echo "Stop all Containers"
	runningContainers=$(docker ps -q)
	if test -n "$runningContainers"
	then
		docker stop $runningContainers
	fi
}

# containers clean
function containersClean
{
	containersStop
	echo "Remove all Containers"
	docker container prune -f
}

# images clean
function imagesClean
{
	echo "Remove all Images"
	images=$(docker images -q)
	if test -n "$images"
	then
		docker image rm -f $images
	fi
}

# volume clean : attention à la perte des données des BD !
function volumesClean
{
	echo "Remove all Volumes"
	if test "$1" != "-f"
	then
		echo "Warning : all Data from Databases will be deleted !"
		echo "Do you want to remove All Volumes (Yes/yes/Y/y/Oui/oui/O/o?"
		read rep
		rep=$(echo "$rep" | tr '[:upper:]' '[:lower:]')
	fi
	if test "$1" = "-f" -o "$rep" = 'yes' -o "$rep" = 'y' -o "$rep" = 'oui' -o "$rep" = 'o'
	then
		volumes=$(docker volume ls -q)
		if test -n "$volumes"
		then
			docker volume rm -f $volumes
		fi
	else
		echo "Volumes are kept"
	fi
}

# all clean
function allClean
{
	echo "Remove All Docker's Ressources : Container - Images - Volumes"
	containersStop
	containersClean
	imagesClean
	volumesClean $1
}

# menu
function menu
{
case $1 in
	"--volumes")
		volumesClean $2
		;;
	"--images")
		imagesClean
		;;
	"--containers")
		containersClean
		;;
	"--all")
		allClean $2
		;;
	*)
		help
		;;
esac
}

# help
function help
{
	printf "$0 [--volumes [-f] | --images | --containers | --all [-f] | --help\n"
	printf "\tClean Docker ressources from the local host\n"
	printf "Options :\n"
	printf "\t--volumes [-f]\t\tRemove all volumes, without confirmation if -f is set\n"
	printf "\t--images\t\tRemove all Images\n"
	printf "\t--containers\t\tStop and remove all containers\n"
	printf "\t--all\t\t\tStop all container, then remove all containers, images and volumes, without confirmation if -f is set\n"
	printf "\t--help\t\t\tShow this help\n"
}

menu "$@"
