#!/usr/bin/env bash
yum install -y bind*
cat >/etc/named.conf<<eof
//
// named.conf
//
// Provided by Red Hat bind package to configure the ISC BIND named(8) DNS
// server as a caching only nameserver (as a localhost DNS resolver only).
//
// See /usr/share/doc/bind*/sample/ for example named configuration files.
//
// See the BIND Administrator's Reference Manual (ARM) for details about the
// configuration located in /usr/share/doc/bind-{version}/Bv9ARM.html

options {
	listen-on port 53 { any; };
	listen-on-v6 port 53 { ::1; };
	directory 	"/var/named";
	dump-file 	"/var/named/data/cache_dump.db";
	statistics-file "/var/named/data/named_stats.txt";
	memstatistics-file "/var/named/data/named_mem_stats.txt";
	recursing-file  "/var/named/data/named.recursing";
	secroots-file   "/var/named/data/named.secroots";
	allow-query     { any; };


/*
	 - If you are building an AUTHORITATIVE DNS server, do NOT enable recursion.
	 - If you are building a RECURSIVE (caching) DNS server, you need to enable
	   recursion.
	 - If your recursive DNS server has a public IP address, you MUST enable access
	   control to limit queries to your legitimate users. Failing to do so will
	   cause your server to become part of large scale DNS amplification
	   attacks. Implementing BCP38 within your network would greatly
	   reduce such attack surface
	*/
	recursion yes;
        forward first;
        forwarders {
        114.114.114.114;
        119.29.29.29;
         };
	dnssec-enable yes;
	dnssec-validation yes;

	/* Path to ISC DLV key */
	bindkeys-file "/etc/named.root.key";

	managed-keys-directory "/var/named/dynamic";

	pid-file "/run/named/named.pid";
	session-keyfile "/run/named/session.key";
};

logging {
        channel default_debug {
                file "data/named.run";
                severity dynamic;
        };
};

zone "." IN {
	type hint;
	file "named.ca";
};

zone "vpn.com" IN{
	type master;
	file "named.vpn.com";
};
zone "0.8.10.in-addr.arpa" IN{
	type master;
	file "named.10.8.0";
};
include "/etc/named.rfc1912.zones";
#include "/etc/named.root.key";
eof
chown root:named /etc/named.conf
cat > /var/named/named.vpn.com <<eof
\$TTL 3H
@	IN SOA	@ rname.invalid. (
					0	; serial
					1D	; refresh
					1H	; retry
					1W	; expire
					3H )	; minimum
	NS	@
	A	10.8.0.1
	AAAA	::1
www.vpn.com. IN A 10.8.0.2
eof

cat > /var/named/named.10.8.0 <<eof
\$TTL 3H
@	IN SOA	@ rname.invalid. (
					0	; serial
					1D	; refresh
					1H	; retry
					1W	; expire
					3H )	; minimum
	NS	@
	A	10.8.0.1
	AAAA	::1
2 PTR www.vpn.com.
1 PTR vpn.com.
eof
cd /var/named/
chown root:named named*
systemctl restart named
systemctl enable named
exit 0