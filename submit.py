#!/usr/bin/python

#Simple script for managing SVN

#Import the os commands
import os
import subprocess
import commands


#Update the files
r = subprocess.call(['cp','/var/www/redesigned/','./','-Ruv'])

#Now see what has changed
output = commands.getoutput('svn status')
print output

#Whats in r?
n = 0
t = 0
for line in output.split('\n'):
	#We have a row
	result = line.split('       ')
	
	if result[0] == '?':
#		thisfile = result[1].split('/')
#		if thisfile[0] == 'trunk' or thisfile[0] == 'branches' or thisfile[0] == 'tags' or thisfile[0] == 'redesigned':
#			r = subprocess.call(['svn','add',result[1]])
#			print result[1] + ' added to SVN';
		r = subprocess.call(['svn','add',result[1]])
		print result[1] + ' added to SVN';
		n += 1
	else:
		t += 1

#How many files were added / edited
if n == 1:
	print "1 file was added, ",
else:
	print str(n) + " files were added, ",
if t == 1:
	print "1 file was changed."
else:
	print str(n) + " files were changed."
		

#Ask for message
t = raw_input("Enter change details: ")

#Add "'s
t = '"' + t + '"'

#And commit
s = subprocess.call(['svn','commit','-m',t])

#Wait to quit
#t = raw_input("Press enter to exit")
os.system('pause')
