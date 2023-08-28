## Esedékességi idő kalkulátor

A program beolvassa az aktuálisan jelentett hibákat egy feladatkövető rendszerből, és az alábbi szabályok szerint kiszámítja az esedékességi dátumot:

* A munkaidő minden munkanapon (hétfőtől péntekig) 9 és 17 óra között van.
* A **program nem kezeli az ünnepnapokat**, ami azt jelenti, hogy egy csütörtöki ünnepnapot ugyanúgy munkanapnak tekinti a program, mint egy szombati munkanapot.
* Az **átfutási idő munkaórában van megadva**, ami azt jelenti, hogy 2 nap 16 óra. Például: ha egy problémát kedden 14:12-kor jelentettek be 16 órás átfutási idővel, akkor az csütörtökön 14:12-re lesz esedékes.
* Egy **problémát csak munkaidőben lehet jelenteni**, ami azt jelenti, hogy minden *beküldési időpont 9 és 17 óra közé esik*.

A feladat a CalculateDueDate metódus implementálása, amely a benyújtási időt és az átfutási időt fogadja bemenetként, és visszaadja azt a dátumot és időpontot, amikorra a problémát meg kell oldani.