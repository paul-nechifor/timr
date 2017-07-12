#!/usr/bin/env python
# -*- coding: utf-8 -*-

import urllib2, sgmllib

class Parser(sgmllib.SGMLParser):
    def parseaza(self, s):
        self.feed(s)
        self.close()
    def __init__(self):
        sgmllib.SGMLParser.__init__(self)
        self.string = ""
        self.zi = ""
        self.truri = []
    def start_tr(self, atribute):
        self.tr = []
    def end_tr(self):
        if len(self.tr) == 1:
            self.zi = self.tr[0]
        if len(self.tr) < 9:
            return
        self.tr.append(self.zi)
        self.truri.append(tuple(self.tr))
    def start_td(self, atribute):
        self.string = ""
    def end_td(self):
        self.tr.append(self.string)
    def handle_data(self, text):
        text = text.strip()
        self.string += text

def inloc(s, l):
    for i in xrange(0, len(l), 2):
        s = s.replace(l[i], l[i + 1])
    return s

materii = []

for parti in ["I1A", "I1B", "I2A", "I2B", "I3A", "I3B"]:
    fisier = urllib2.urlopen("http://thor.info.uaic.ro/~orar/participanti/orar_%s.html" % parti).read()
    parser = Parser()
    parser.parseaza(fisier)
    materii.extend(parser.truri)

materii = list(set(materii))
profesori = []
discipline = []
sali = []

for r in materii:
    parti = "," + r[2] + ","
    start = r[0][:2]
    final = r[1][:2]
    den = r[3]
    tip = r[4].lower()
    titprof = ""
    prof = r[5]
    sala = r[6].replace(",video", "")
    frec = r[7][:-1].lower()

    zi = r[-1].lower()
    zi = inloc(zi, ["luni", "0", "marti", "1", "miercuri", "2", "joi", "3", "vineri", "4", "sambata", "5", "duminica", "6"])

    try:
        i = prof.index("\r")
        prof = prof[:i - 1]
    except ValueError:
        pass

    s = prof.split(".")
    if len(s) > 1:
        titprof = ". ".join(s[:-1]).lower() + "."
        prof = s[-1][1:]


    profesori.append(prof)
    discipline.append(den)
    if sala[0] == "C" and len(sala) < 6:
        sali.append(sala)


    s = prof.split(" ")
    prof = " ".join(s[1:] + [s[0]])


    names = "parti, zi, start, final, den, tip, titprof, prof, sala, frec"

    values = "'%s', %s, %s, %s, '%s', '%s', '%s', '%s', '%s', '%s'" % \
            (parti, zi, start, final, den, tip, titprof, prof, sala, frec)

    print "insert into discipline (%s) values (%s);" % (names, values)

profesori = list(set(profesori))
profesori.sort()
for i in xrange(len(profesori)):
    s = profesori[i].split(" ")
    profesori[i] = " ".join(s[1:] + [s[0]])
discipline = list(set(discipline))
discipline.sort()
sali = list(set(sali))
sali.sort()

for p in profesori: print "insert into profi (nume) values ('%s');" % p
for p in sali: print "insert into sali (nume) values ('%s');" % p
for p in discipline: print "insert into materii (nume) values ('%s');" % p
