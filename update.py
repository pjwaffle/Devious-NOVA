#!/usr/bin/python

#Import the os commands
import os
import subprocess

#Let them know we are starting
print "Starting update ..."
print " "

#Now update
r = subprocess.call(['svn','update'])

#Its done
print " "
print "... Done"

#Wait to quit
t = raw_input("Press enter to update files on localhost server.")

#Update the files
r = subprocess.call(['cp','./redesigned/','/var/www/','-Ru'])

#Wait to quit
t = raw_input("Press enter to exit.")
