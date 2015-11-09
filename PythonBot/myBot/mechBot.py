import mechanize

br = mechanize.Browser()
br.set_handle_robots(False)
fb = br.open("https://www.njit.edu/cp/login.php")

for form in br.forms():
	print "Form Name:", form.name
	for ctrl in br.form.controls:
		print ctrl
	print form