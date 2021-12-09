-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Jun 2021 pada 03.37
-- Versi server: 10.4.13-MariaDB
-- Versi PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `psikotest`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `nama`, `email`, `password`) VALUES
(3, 'luar_biasa', 'sdsdjshj', 'a@gmail.com', 'c28944454def510a950e8d17bae49f8f'),
(7, 'andre09', 'andre', 'andre@gmail.com', '19984dcaea13176bbb694f62ba6b5b35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hapalan`
--

CREATE TABLE `hapalan` (
  `id` int(11) NOT NULL,
  `soal_id` int(11) NOT NULL,
  `nama_modul` varchar(45) NOT NULL,
  `gambar_hapalan` text NOT NULL,
  `durasi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `hapalan`
--

INSERT INTO `hapalan` (`id`, `soal_id`, `nama_modul`, `gambar_hapalan`, `durasi`) VALUES
(3, 2, 'Modul 2', 'Modul 2_2.png', 180);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jawaban_modul`
--

CREATE TABLE `jawaban_modul` (
  `room_id` int(11) NOT NULL,
  `peserta_id` int(11) NOT NULL,
  `soal_1` text NOT NULL,
  `skor_1` text NOT NULL,
  `soal_2` text NOT NULL,
  `skor_2` text NOT NULL,
  `soal_3` text NOT NULL,
  `skor_3` text NOT NULL,
  `soal_4` text NOT NULL,
  `skor_4` text NOT NULL,
  `soal_5` text NOT NULL,
  `skor_5` text NOT NULL,
  `soal_6` text NOT NULL,
  `skor_6` text NOT NULL,
  `soal_7` text NOT NULL,
  `skor_7` text NOT NULL,
  `soal_8` text NOT NULL,
  `skor_8` text NOT NULL,
  `soal_9` text NOT NULL,
  `skor_9` text NOT NULL,
  `soal_10_se` text NOT NULL,
  `soal_10_wa` text NOT NULL,
  `soal_10_an` text NOT NULL,
  `soal_10_ra` text NOT NULL,
  `soal_10_zr` text NOT NULL,
  `soal_10_ge` text NOT NULL,
  `soal_10_fa` text NOT NULL,
  `soal_10_wu` text NOT NULL,
  `skor_10` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jawaban_modul`
--

INSERT INTO `jawaban_modul` (`room_id`, `peserta_id`, `soal_1`, `skor_1`, `soal_2`, `skor_2`, `soal_3`, `skor_3`, `soal_4`, `skor_4`, `soal_5`, `skor_5`, `soal_6`, `skor_6`, `soal_7`, `skor_7`, `soal_8`, `skor_8`, `soal_9`, `skor_9`, `soal_10_se`, `soal_10_wa`, `soal_10_an`, `soal_10_ra`, `soal_10_zr`, `soal_10_ge`, `soal_10_fa`, `soal_10_wu`, `skor_10`) VALUES
(1, 1, '1=3;2= ;3= ;4= ;5= ;6= ;7= ;8= ;9= ;10= ;11= ;12= ;13= ;14= ;15= ;16= ;17= ;18= ;19= ;20= ;21= ;22= ;23= ;24= ;25= ;26= ;27= ;28= ;29= ;30= ', 'SK B :0', '1=burung;2=binatang;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=', 'B :1', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0),
(1, 1, '1=3;2= ;3= ;4= ;5= ;6= ;7= ;8= ;9= ;10= ;11= ;12= ;13= ;14= ;15= ;16= ;17= ;18= ;19= ;20= ;21= ;22= ;23= ;24= ;25= ;26= ;27= ;28= ;29= ;30= ', 'SK B :0', '1=burung;2=binatang;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=', 'B :1', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0),
(1, 1, '1=3;2= ;3= ;4= ;5= ;6= ;7= ;8= ;9= ;10= ;11= ;12= ;13= ;14= ;15= ;16= ;17= ;18= ;19= ;20= ;21= ;22= ;23= ;24= ;25= ;26= ;27= ;28= ;29= ;30= ', 'SK B :0', '1=burung;2=binatang;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=', 'B :1', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0),
(3, 5, '1= ;2= ;3= ;4= ;5= ;6= ;7= ;8= ;9= ;10= ;11= ;12= ;13= ;14= ;15= ;16= ;17= ;18= ;19= ;20= ;21= ;22= ;23= ;24= ;25= ;26= ;27= ;28= ;29= ;30= ', 'SK B :0', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=', 'B :0', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=;21=;22=;23=;24=;25=;26=;27=;28=;29=;30=;31=;32=;33=;34=;35=;36=;37=;38=;39=;40=;41=;42=;43=;44=;45=;46=;47=;48=;49=;50=;51=;52=;53=;54=;55=;56=;57=;58=;59=;60=;61=;62=;63=;64=;65=;66=;67=;68=;69=;70=;71=;72=;73=;74=;75=;76=;77=;78=;79=;80=;81=;82=;83=;84=;85=;86=;87=;88=;89=;90=;91=;92=;93=;94=;95=;96=;97=;98=;99=;100=', 'SK | B:0', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=', 'B :0', '1=I,C;2=C,S;3=S,D;4=D,I;5=S,D;6=*,S;7=*,S;8=*,C;9=I,*;10=S,I;11=I,*;12=I,S;13=S,D;14=S,*;15=D,C;16=S,I;17=I,*;18=*,D;19=*,I;20=D,I;21=S,C;22=D,C;23=*,*;24=I,*;', 'M_D=4;M_I=6;M_S=7;M_C=1;M_*=6;Null=0;&lt;br&gt;L_D=4;L_I=5;L_S=4;L_C=5;L_*=6;Null=0;&lt;br&gt;C_D=0;C_I=1;C_S=3;C_C=-4;', '1=G;2=N;3=A;4=P;5=X;6=B;7=O;8=Z;9=K;10=F;11=C;12=E;13=N;14=A;15=P;16=X;17=B;18=O;19=Z;20=K;21=D;22=C;23=E;24=N;25=A;26=P;27=X;28=B;29=O;30=Z;31=R;32=D;33=C;34=E;35=N;36=A;37=P;38=X;39=B;40=O;41=S;42=L;43=D;44=C;45=E;46=N;47=A;48=P;49=X;50=B;51=V;52=S;53=R;54=D;55=C;56=E;57=N;58=A;59=P;60=X;61=T;62=V;63=S;64=R;65=D;66=C;67=E;68=N;69=A;70=P;71=I;72=T;73=V;74=S;75=R;76=D;77=C;78=E;79=N;80=A;81=L;82=I;83=T;84=V;85=S;86=R;87=D;88=C;89=E;90=N', 'A=8;B=5;C=8;D=7;E=8;F=1;G=1;H=0;I=2;K=2;L=2;N=9;O=4;P=7;R=5;S=5;T=3;V=4;W=0;X=6;Z=3;Null=0', '', '', '1=4;2=2;3=3;4=2;5=4;6=3;7=3;8=2;9=3;10=2;11=2;12=1;13=2;14=2;15=3;16=2;17=2;18=2;19=4;20=3;21=3;22=3;23=1;24=3;25=1;26=3;27=1;28=1;29=3;30=3;31=1;32=2;33=2;34=2;35=3;36=4;37=2', 'QF=CS;CI=CS;C=CS;CO=BS;I=S;', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=;21=;22=;23=;24=;25=;26=;27=;28=;29=;30=;31=;32=;33=;34=;35=;36=;37=;38=;39=;40=;41=;42=;', 'R=0;I=0;A=0;S=0;E=0;C=0', '', '', '', '', '', '', '', '', 0),
(3, 5, '1= ;2= ;3= ;4= ;5= ;6= ;7= ;8= ;9= ;10= ;11= ;12= ;13= ;14= ;15= ;16= ;17= ;18= ;19= ;20= ;21= ;22= ;23= ;24= ;25= ;26= ;27= ;28= ;29= ;30= ', 'SK B :0', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=', 'B :0', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=;21=;22=;23=;24=;25=;26=;27=;28=;29=;30=;31=;32=;33=;34=;35=;36=;37=;38=;39=;40=;41=;42=;43=;44=;45=;46=;47=;48=;49=;50=;51=;52=;53=;54=;55=;56=;57=;58=;59=;60=;61=;62=;63=;64=;65=;66=;67=;68=;69=;70=;71=;72=;73=;74=;75=;76=;77=;78=;79=;80=;81=;82=;83=;84=;85=;86=;87=;88=;89=;90=;91=;92=;93=;94=;95=;96=;97=;98=;99=;100=', 'SK | B:0', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=', 'B :0', '1=I,C;2=C,S;3=S,D;4=D,I;5=S,D;6=*,S;7=*,S;8=*,C;9=I,*;10=S,I;11=I,*;12=I,S;13=S,D;14=S,*;15=D,C;16=S,I;17=I,*;18=*,D;19=*,I;20=D,I;21=S,C;22=D,C;23=*,*;24=I,*;', 'M_D=4;M_I=6;M_S=7;M_C=1;M_*=6;Null=0;&lt;br&gt;L_D=4;L_I=5;L_S=4;L_C=5;L_*=6;Null=0;&lt;br&gt;C_D=0;C_I=1;C_S=3;C_C=-4;', '1=G;2=N;3=A;4=P;5=X;6=B;7=O;8=Z;9=K;10=F;11=C;12=E;13=N;14=A;15=P;16=X;17=B;18=O;19=Z;20=K;21=D;22=C;23=E;24=N;25=A;26=P;27=X;28=B;29=O;30=Z;31=R;32=D;33=C;34=E;35=N;36=A;37=P;38=X;39=B;40=O;41=S;42=L;43=D;44=C;45=E;46=N;47=A;48=P;49=X;50=B;51=V;52=S;53=R;54=D;55=C;56=E;57=N;58=A;59=P;60=X;61=T;62=V;63=S;64=R;65=D;66=C;67=E;68=N;69=A;70=P;71=I;72=T;73=V;74=S;75=R;76=D;77=C;78=E;79=N;80=A;81=L;82=I;83=T;84=V;85=S;86=R;87=D;88=C;89=E;90=N', 'A=8;B=5;C=8;D=7;E=8;F=1;G=1;H=0;I=2;K=2;L=2;N=9;O=4;P=7;R=5;S=5;T=3;V=4;W=0;X=6;Z=3;Null=0', '', '', '1=4;2=2;3=3;4=2;5=4;6=3;7=3;8=2;9=3;10=2;11=2;12=1;13=2;14=2;15=3;16=2;17=2;18=2;19=4;20=3;21=3;22=3;23=1;24=3;25=1;26=3;27=1;28=1;29=3;30=3;31=1;32=2;33=2;34=2;35=3;36=4;37=2', 'QF=CS;CI=CS;C=CS;CO=BS;I=S;', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=;21=;22=;23=;24=;25=;26=;27=;28=;29=;30=;31=;32=;33=;34=;35=;36=;37=;38=;39=;40=;41=;42=;', 'R=0;I=0;A=0;S=0;E=0;C=0', '', '', '', '', '', '', '', '', 0),
(3, 5, '1= ;2= ;3= ;4= ;5= ;6= ;7= ;8= ;9= ;10= ;11= ;12= ;13= ;14= ;15= ;16= ;17= ;18= ;19= ;20= ;21= ;22= ;23= ;24= ;25= ;26= ;27= ;28= ;29= ;30= ', 'SK B :0', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=', 'B :0', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=;21=;22=;23=;24=;25=;26=;27=;28=;29=;30=;31=;32=;33=;34=;35=;36=;37=;38=;39=;40=;41=;42=;43=;44=;45=;46=;47=;48=;49=;50=;51=;52=;53=;54=;55=;56=;57=;58=;59=;60=;61=;62=;63=;64=;65=;66=;67=;68=;69=;70=;71=;72=;73=;74=;75=;76=;77=;78=;79=;80=;81=;82=;83=;84=;85=;86=;87=;88=;89=;90=;91=;92=;93=;94=;95=;96=;97=;98=;99=;100=', 'SK | B:0', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=', 'B :0', '1=I,C;2=C,S;3=S,D;4=D,I;5=S,D;6=*,S;7=*,S;8=*,C;9=I,*;10=S,I;11=I,*;12=I,S;13=S,D;14=S,*;15=D,C;16=S,I;17=I,*;18=*,D;19=*,I;20=D,I;21=S,C;22=D,C;23=*,*;24=I,*;', 'M_D=4;M_I=6;M_S=7;M_C=1;M_*=6;Null=0;&lt;br&gt;L_D=4;L_I=5;L_S=4;L_C=5;L_*=6;Null=0;&lt;br&gt;C_D=0;C_I=1;C_S=3;C_C=-4;', '1=G;2=N;3=A;4=P;5=X;6=B;7=O;8=Z;9=K;10=F;11=C;12=E;13=N;14=A;15=P;16=X;17=B;18=O;19=Z;20=K;21=D;22=C;23=E;24=N;25=A;26=P;27=X;28=B;29=O;30=Z;31=R;32=D;33=C;34=E;35=N;36=A;37=P;38=X;39=B;40=O;41=S;42=L;43=D;44=C;45=E;46=N;47=A;48=P;49=X;50=B;51=V;52=S;53=R;54=D;55=C;56=E;57=N;58=A;59=P;60=X;61=T;62=V;63=S;64=R;65=D;66=C;67=E;68=N;69=A;70=P;71=I;72=T;73=V;74=S;75=R;76=D;77=C;78=E;79=N;80=A;81=L;82=I;83=T;84=V;85=S;86=R;87=D;88=C;89=E;90=N', 'A=8;B=5;C=8;D=7;E=8;F=1;G=1;H=0;I=2;K=2;L=2;N=9;O=4;P=7;R=5;S=5;T=3;V=4;W=0;X=6;Z=3;Null=0', '', '', '1=4;2=2;3=3;4=2;5=4;6=3;7=3;8=2;9=3;10=2;11=2;12=1;13=2;14=2;15=3;16=2;17=2;18=2;19=4;20=3;21=3;22=3;23=1;24=3;25=1;26=3;27=1;28=1;29=3;30=3;31=1;32=2;33=2;34=2;35=3;36=4;37=2', 'QF=CS;CI=CS;C=CS;CO=BS;I=S;', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=;21=;22=;23=;24=;25=;26=;27=;28=;29=;30=;31=;32=;33=;34=;35=;36=;37=;38=;39=;40=;41=;42=;', 'R=0;I=0;A=0;S=0;E=0;C=0', '', '', '', '', '', '', '', '', 0),
(3, 5, '1= ;2= ;3= ;4= ;5= ;6= ;7= ;8= ;9= ;10= ;11= ;12= ;13= ;14= ;15= ;16= ;17= ;18= ;19= ;20= ;21= ;22= ;23= ;24= ;25= ;26= ;27= ;28= ;29= ;30= ', 'SK B :0', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=', 'B :0', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=;21=;22=;23=;24=;25=;26=;27=;28=;29=;30=;31=;32=;33=;34=;35=;36=;37=;38=;39=;40=;41=;42=;43=;44=;45=;46=;47=;48=;49=;50=;51=;52=;53=;54=;55=;56=;57=;58=;59=;60=;61=;62=;63=;64=;65=;66=;67=;68=;69=;70=;71=;72=;73=;74=;75=;76=;77=;78=;79=;80=;81=;82=;83=;84=;85=;86=;87=;88=;89=;90=;91=;92=;93=;94=;95=;96=;97=;98=;99=;100=', 'SK | B:0', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=', 'B :0', '1=I,C;2=C,S;3=S,D;4=D,I;5=S,D;6=*,S;7=*,S;8=*,C;9=I,*;10=S,I;11=I,*;12=I,S;13=S,D;14=S,*;15=D,C;16=S,I;17=I,*;18=*,D;19=*,I;20=D,I;21=S,C;22=D,C;23=*,*;24=I,*;', 'M_D=4;M_I=6;M_S=7;M_C=1;M_*=6;Null=0;&lt;br&gt;L_D=4;L_I=5;L_S=4;L_C=5;L_*=6;Null=0;&lt;br&gt;C_D=0;C_I=1;C_S=3;C_C=-4;', '1=G;2=N;3=A;4=P;5=X;6=B;7=O;8=Z;9=K;10=F;11=C;12=E;13=N;14=A;15=P;16=X;17=B;18=O;19=Z;20=K;21=D;22=C;23=E;24=N;25=A;26=P;27=X;28=B;29=O;30=Z;31=R;32=D;33=C;34=E;35=N;36=A;37=P;38=X;39=B;40=O;41=S;42=L;43=D;44=C;45=E;46=N;47=A;48=P;49=X;50=B;51=V;52=S;53=R;54=D;55=C;56=E;57=N;58=A;59=P;60=X;61=T;62=V;63=S;64=R;65=D;66=C;67=E;68=N;69=A;70=P;71=I;72=T;73=V;74=S;75=R;76=D;77=C;78=E;79=N;80=A;81=L;82=I;83=T;84=V;85=S;86=R;87=D;88=C;89=E;90=N', 'A=8;B=5;C=8;D=7;E=8;F=1;G=1;H=0;I=2;K=2;L=2;N=9;O=4;P=7;R=5;S=5;T=3;V=4;W=0;X=6;Z=3;Null=0', '', '', '1=4;2=2;3=3;4=2;5=4;6=3;7=3;8=2;9=3;10=2;11=2;12=1;13=2;14=2;15=3;16=2;17=2;18=2;19=4;20=3;21=3;22=3;23=1;24=3;25=1;26=3;27=1;28=1;29=3;30=3;31=1;32=2;33=2;34=2;35=3;36=4;37=2', 'QF=CS;CI=CS;C=CS;CO=BS;I=S;', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=;21=;22=;23=;24=;25=;26=;27=;28=;29=;30=;31=;32=;33=;34=;35=;36=;37=;38=;39=;40=;41=;42=;', 'R=0;I=0;A=0;S=0;E=0;C=0', '', '', '', '', '', '', '', '', 0),
(3, 5, '1= ;2= ;3= ;4= ;5= ;6= ;7= ;8= ;9= ;10= ;11= ;12= ;13= ;14= ;15= ;16= ;17= ;18= ;19= ;20= ;21= ;22= ;23= ;24= ;25= ;26= ;27= ;28= ;29= ;30= ', 'SK B :0', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=', 'B :0', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=;21=;22=;23=;24=;25=;26=;27=;28=;29=;30=;31=;32=;33=;34=;35=;36=;37=;38=;39=;40=;41=;42=;43=;44=;45=;46=;47=;48=;49=;50=;51=;52=;53=;54=;55=;56=;57=;58=;59=;60=;61=;62=;63=;64=;65=;66=;67=;68=;69=;70=;71=;72=;73=;74=;75=;76=;77=;78=;79=;80=;81=;82=;83=;84=;85=;86=;87=;88=;89=;90=;91=;92=;93=;94=;95=;96=;97=;98=;99=;100=', 'SK | B:0', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=', 'B :0', '1=I,C;2=C,S;3=S,D;4=D,I;5=S,D;6=*,S;7=*,S;8=*,C;9=I,*;10=S,I;11=I,*;12=I,S;13=S,D;14=S,*;15=D,C;16=S,I;17=I,*;18=*,D;19=*,I;20=D,I;21=S,C;22=D,C;23=*,*;24=I,*;', 'M_D=4;M_I=6;M_S=7;M_C=1;M_*=6;Null=0;&lt;br&gt;L_D=4;L_I=5;L_S=4;L_C=5;L_*=6;Null=0;&lt;br&gt;C_D=0;C_I=1;C_S=3;C_C=-4;', '1=G;2=N;3=A;4=P;5=X;6=B;7=O;8=Z;9=K;10=F;11=C;12=E;13=N;14=A;15=P;16=X;17=B;18=O;19=Z;20=K;21=D;22=C;23=E;24=N;25=A;26=P;27=X;28=B;29=O;30=Z;31=R;32=D;33=C;34=E;35=N;36=A;37=P;38=X;39=B;40=O;41=S;42=L;43=D;44=C;45=E;46=N;47=A;48=P;49=X;50=B;51=V;52=S;53=R;54=D;55=C;56=E;57=N;58=A;59=P;60=X;61=T;62=V;63=S;64=R;65=D;66=C;67=E;68=N;69=A;70=P;71=I;72=T;73=V;74=S;75=R;76=D;77=C;78=E;79=N;80=A;81=L;82=I;83=T;84=V;85=S;86=R;87=D;88=C;89=E;90=N', 'A=8;B=5;C=8;D=7;E=8;F=1;G=1;H=0;I=2;K=2;L=2;N=9;O=4;P=7;R=5;S=5;T=3;V=4;W=0;X=6;Z=3;Null=0', '', '', '1=4;2=2;3=3;4=2;5=4;6=3;7=3;8=2;9=3;10=2;11=2;12=1;13=2;14=2;15=3;16=2;17=2;18=2;19=4;20=3;21=3;22=3;23=1;24=3;25=1;26=3;27=1;28=1;29=3;30=3;31=1;32=2;33=2;34=2;35=3;36=4;37=2', 'QF=CS;CI=CS;C=CS;CO=BS;I=S;', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=;21=;22=;23=;24=;25=;26=;27=;28=;29=;30=;31=;32=;33=;34=;35=;36=;37=;38=;39=;40=;41=;42=;', 'R=0;I=0;A=0;S=0;E=0;C=0', '', '', '', '', '', '', '', '', 0),
(3, 5, '1= ;2= ;3= ;4= ;5= ;6= ;7= ;8= ;9= ;10= ;11= ;12= ;13= ;14= ;15= ;16= ;17= ;18= ;19= ;20= ;21= ;22= ;23= ;24= ;25= ;26= ;27= ;28= ;29= ;30= ', 'SK B :0', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=', 'B :0', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=;21=;22=;23=;24=;25=;26=;27=;28=;29=;30=;31=;32=;33=;34=;35=;36=;37=;38=;39=;40=;41=;42=;43=;44=;45=;46=;47=;48=;49=;50=;51=;52=;53=;54=;55=;56=;57=;58=;59=;60=;61=;62=;63=;64=;65=;66=;67=;68=;69=;70=;71=;72=;73=;74=;75=;76=;77=;78=;79=;80=;81=;82=;83=;84=;85=;86=;87=;88=;89=;90=;91=;92=;93=;94=;95=;96=;97=;98=;99=;100=', 'SK | B:0', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=', 'B :0', '1=I,C;2=C,S;3=S,D;4=D,I;5=S,D;6=*,S;7=*,S;8=*,C;9=I,*;10=S,I;11=I,*;12=I,S;13=S,D;14=S,*;15=D,C;16=S,I;17=I,*;18=*,D;19=*,I;20=D,I;21=S,C;22=D,C;23=*,*;24=I,*;', 'M_D=4;M_I=6;M_S=7;M_C=1;M_*=6;Null=0;&lt;br&gt;L_D=4;L_I=5;L_S=4;L_C=5;L_*=6;Null=0;&lt;br&gt;C_D=0;C_I=1;C_S=3;C_C=-4;', '1=G;2=N;3=A;4=P;5=X;6=B;7=O;8=Z;9=K;10=F;11=C;12=E;13=N;14=A;15=P;16=X;17=B;18=O;19=Z;20=K;21=D;22=C;23=E;24=N;25=A;26=P;27=X;28=B;29=O;30=Z;31=R;32=D;33=C;34=E;35=N;36=A;37=P;38=X;39=B;40=O;41=S;42=L;43=D;44=C;45=E;46=N;47=A;48=P;49=X;50=B;51=V;52=S;53=R;54=D;55=C;56=E;57=N;58=A;59=P;60=X;61=T;62=V;63=S;64=R;65=D;66=C;67=E;68=N;69=A;70=P;71=I;72=T;73=V;74=S;75=R;76=D;77=C;78=E;79=N;80=A;81=L;82=I;83=T;84=V;85=S;86=R;87=D;88=C;89=E;90=N', 'A=8;B=5;C=8;D=7;E=8;F=1;G=1;H=0;I=2;K=2;L=2;N=9;O=4;P=7;R=5;S=5;T=3;V=4;W=0;X=6;Z=3;Null=0', '', '', '1=4;2=2;3=3;4=2;5=4;6=3;7=3;8=2;9=3;10=2;11=2;12=1;13=2;14=2;15=3;16=2;17=2;18=2;19=4;20=3;21=3;22=3;23=1;24=3;25=1;26=3;27=1;28=1;29=3;30=3;31=1;32=2;33=2;34=2;35=3;36=4;37=2', 'QF=CS;CI=CS;C=CS;CO=BS;I=S;', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=;21=;22=;23=;24=;25=;26=;27=;28=;29=;30=;31=;32=;33=;34=;35=;36=;37=;38=;39=;40=;41=;42=;', 'R=0;I=0;A=0;S=0;E=0;C=0', '', '', '', '', '', '', '', '', 0),
(3, 6, '', '', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=', 'B :0', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=;21=;22=;23=;24=;25=;26=;27=;28=;29=;30=;31=;32=;33=;34=;35=;36=;37=;38=;39=;40=;41=;42=;43=;44=;45=;46=;47=;48=;49=;50=;51=;52=;53=;54=;55=;56=;57=;58=;59=;60=;61=;62=;63=;64=;65=;66=;67=;68=;69=;70=;71=;72=;73=;74=;75=;76=;77=;78=;79=;80=;81=;82=;83=;84=;85=;86=;87=;88=;89=;90=;91=;92=;93=;94=;95=;96=;97=;98=;99=;100=', 'SK | B:0', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=', 'B :0', '1=S,C;2=C,S;3=D,S;4=D,I;5=D,S;6=*,S;7=*,S;8=*,D;9=S,I;10=S,I;11=C,I;12=S,I;13=D,S;14=S,*;15=D,I;16=D,I;17=I,*;18=*,D;19=I,D;20=C,I;21=I,S;22=S,C;23=C,I;24=I,*;', 'M_D=6;M_I=4;M_S=6;M_C=4;M_*=4;Null=0;&lt;br&gt;L_D=3;L_I=9;L_S=7;L_C=2;L_*=3;Null=0;&lt;br&gt;C_D=3;C_I=-5;C_S=-1;C_C=2;', '1=E;2=N;3=A;4=P;5=X;6=B;7=O;8=Z;9=K;10=F;11=C;12=E;13=N;14=A;15=P;16=X;17=B;18=O;19=Z;20=K;21=D;22=C;23=E;24=N;25=A;26=P;27=X;28=B;29=F;30=Z;31=R;32=D;33=C;34=E;35=N;36=A;37=P;38=X;39=B;40=O;41=S;42=R;43=D;44=C;45=E;46=N;47=A;48=P;49=X;50=B;51=V;52=S;53=R;54=D;55=C;56=E;57=N;58=A;59=P;60=X;61=T;62=V;63=S;64=R;65=D;66=C;67=E;68=N;69=A;70=P;71=I;72=T;73=V;74=S;75=R;76=D;77=C;78=E;79=N;80=A;81=L;82=I;83=T;84=V;85=S;86=R;87=D;88=C;89=E;90=N', 'A=8;B=5;C=8;D=7;E=9;F=2;G=0;H=0;I=2;K=2;L=1;N=9;O=3;P=7;R=6;S=5;T=3;V=4;W=0;X=6;Z=3;Null=0', '1=A;2=B;3=B;4=B;5=B;6=B;7=B;8=A;9=A;10=B;11=B;12=B;13=B;14=A;15=B;16=B;17=B;18=A;19=A;20=A;21=A;22=A;23=A;24=B;25=B;26=B;27=B;28=B;29=B;30=B;31=B;32=A;33=A;34=B;35=B;36=B;37=A;38=B;39=B;40=B;41=B;42=B;43=B;44=B;45=B;46=B;47=B;48=B;49=B;50=B;51=B;52=B;53=B;54=B;55=B;56=B;57=B;58=A;59=B;60=B;61=B;62=B;63=B;64=B', 'TO=32|RO=26|E=26|O=8', '1=1;2=3;3=3;4=2;5=2;6=2;7=3;8=3;9=2;10=3;11=4;12=2;13=3;14=2;15=2;16=3;17=2;18=3;19=3;20=2;21=2;22=2;23=2;24=1;25=3;26=3;27=2;28=3;29=2;30=3;31=3;32=3;33=4;34=2;35=3;36=2;37=3', 'QF=CS;CI=CS;C=CS;CO=CS;I=S;', '1=R;2=;3=;4=;5=E;6=;7=R;8=A;9=C;10=;11=;12=S;13=S;14=;15=C;16=;17=A;18=I;19=;20=S;21=I;22=;23=;24=;25=C;26=I;27=A;28=S;29=;30=R;31=A;32=R;33=I;34=S;35=C;36=E;37=;38=;39=I;40=S;41=A;42=E;', 'R=4;I=5;A=5;S=6;E=3;C=4', '1=;2=;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=;', '21=;22=;23=;24=;25=;26=;27=;28=;29=;30=;31=;32=;33=;34=;35=;36=;37=;38=;39=;40=;', '', '', '', '', '', '', 0),
(1, 1, '1=3;2= ;3= ;4= ;5= ;6= ;7= ;8= ;9= ;10= ;11= ;12= ;13= ;14= ;15= ;16= ;17= ;18= ;19= ;20= ;21= ;22= ;23= ;24= ;25= ;26= ;27= ;28= ;29= ;30= ', 'SK B :0', '1=burung;2=binatang;3=;4=;5=;6=;7=;8=;9=;10=;11=;12=;13=;14=;15=;16=;17=;18=;19=;20=', 'B :1', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul_1`
--

CREATE TABLE `modul_1` (
  `id` int(11) NOT NULL,
  `soal_id` int(11) NOT NULL,
  `nomor_soal` int(11) NOT NULL,
  `link_gambar` varchar(75) NOT NULL,
  `kunci_jawaban` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `modul_1`
--

INSERT INTO `modul_1` (`id`, `soal_id`, `nomor_soal`, `link_gambar`, `kunci_jawaban`) VALUES
(1, 1, 1, '1_1_1.png', 2),
(3, 1, 2, '2_1_2.png', 5),
(4, 1, 3, '3_1_3.png', 4),
(5, 1, 4, '4_1_4.png', 4),
(6, 1, 5, '5_1_5.png', 5),
(7, 1, 6, '6_1_6.png', 4),
(8, 1, 7, '7_1_7.png', 5),
(9, 1, 8, '8_1_8.png', 1),
(10, 1, 9, '9_1_9.png', 5),
(11, 1, 10, '10_1_10.png', 3),
(12, 1, 11, '11_1_11.png', 5),
(13, 1, 12, '12_1_12.png', 4),
(14, 1, 13, '13_1_13.png', 5),
(15, 1, 14, '14_1_14.png', 3),
(16, 1, 15, '15_1_15.png', 2),
(17, 1, 16, '16_1_16.png', 3),
(18, 1, 17, '17_1_17.png', 2),
(19, 1, 18, '18_1_18.png', 3),
(20, 1, 19, '19_1_19.png', 4),
(21, 1, 20, '20_1_20.png', 4),
(22, 1, 21, '21_1_21.png', 3),
(23, 1, 22, '22_1_22.png', 3),
(24, 1, 23, '23_1_23.png', 4),
(25, 1, 24, '24_1_24.png', 4),
(26, 1, 25, '25_1_25.png', 5),
(27, 1, 26, '26_1_26.png', 1),
(28, 1, 27, '27_1_27.png', 2),
(29, 1, 28, '28_1_28.png', 5),
(30, 1, 29, '29_1_29.png', 3),
(31, 1, 30, '30_1_30.png', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul_2`
--

CREATE TABLE `modul_2` (
  `id` int(11) NOT NULL,
  `soal_id` int(11) NOT NULL,
  `nomor_soal` int(11) NOT NULL,
  `teks_soal` text NOT NULL,
  `kunci_jawaban` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `modul_2`
--

INSERT INTO `modul_2` (`id`, `soal_id`, `nomor_soal`, `teks_soal`, `kunci_jawaban`) VALUES
(1, 2, 1, 'Kata yang mempunyai huruf permulaan A - adalah.......', 'kesenian'),
(2, 2, 2, 'Kata yang mempunyai huruf permulaan B - adalah.......', 'binatang'),
(6, 2, 3, 'Kata yang mempunyai huruf permulaan C - adalah.......', 'perkakas'),
(8, 2, 4, 'Kata yang mempunyai huruf permulaan D - adalah.......					\r\n', 'bunga'),
(9, 2, 5, 'Kata yang mempunyai huruf permulaan E - adalah.......					\r\n', 'burung'),
(10, 2, 6, 'Kata yang mempunyai huruf permulaan F - adalah.......					\r\n', 'bunga'),
(11, 2, 7, 'Kata yang mempunyai huruf permulaan G - adalah.......					\r\n', 'kesenian'),
(12, 2, 8, 'Kata yang mempunyai huruf permulaan H - adalah.......					\r\n', 'binatang'),
(13, 2, 9, 'Kata yang mempunyai huruf permulaan I - adalah.......					\r\n', 'burung'),
(14, 2, 10, 'Kata yang mempunyai huruf permulaan J - adalah.......					\r\n', 'perkakas'),
(15, 2, 11, 'Kata yang mempunyai huruf permulaan K - adalah.......					\r\n', 'perkakas'),
(16, 2, 12, 'Kata yang mempunyai huruf permulaan L - adalah.......					\r\n', 'bunga'),
(17, 2, 13, 'Kata yang mempunyai huruf permulaan M - adalah.......					\r\n', 'binatang'),
(18, 2, 14, 'Kata yang mempunyai huruf permulaan N - adalah.......					\r\n', 'burung'),
(19, 2, 15, 'Kata yang mempunyai huruf permulaan O - adalah.......					\r\n', 'kesenian'),
(20, 2, 16, 'Kata yang mempunyai huruf permulaan P - adalah.......					\r\n', 'perkakas'),
(21, 2, 17, 'Kata yang mempunyai huruf permulaan R - adalah.......					\r\n', 'binatang'),
(22, 2, 18, 'Kata yang mempunyai huruf permulaan S - adalah.......					\r\n', 'bunga'),
(23, 2, 19, 'Kata yang mempunyai huruf permulaan T - adalah.......					\r\n', 'burung'),
(24, 2, 20, 'Kata yang mempunyai huruf permulaan U - adalah.......					\r\n', 'kesenian');

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul_3`
--

CREATE TABLE `modul_3` (
  `id` int(11) NOT NULL,
  `soal_id` int(11) NOT NULL,
  `nomor_soal` int(11) NOT NULL,
  `pernyataan_1` text DEFAULT NULL,
  `pernyataan_2` text DEFAULT NULL,
  `kunci_jawaban` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `modul_3`
--

INSERT INTO `modul_3` (`id`, `soal_id`, `nomor_soal`, `pernyataan_1`, `pernyataan_2`, `kunci_jawaban`) VALUES
(1, 3, 1, 'Merpati Nusantara\r\n', 'Merpati Nusantara\r\n', 'benar'),
(2, 3, 3, 'Bank Bumi Daya\r\n', 'Bank Bumi Daya\r\n', 'benar'),
(3, 3, 2, 'Annanda\r\n', 'Ananda\r\n', 'salah'),
(4, 3, 4, 'Sussie Flowershop\r\n', 'Sussie Flowershop\r\n', 'salah'),
(9, 3, 5, 'Fakultas Psikologi UI', 'Fakultas Fisiologi UI', 'salah'),
(10, 3, 7, 'Bengkel Motor &quot;Lancar&quot;', 'Bengkel Motor &quot;Laju&quot;', 'salah'),
(12, 3, 6, 'Jogjakarta Package Tour', 'Jogjakarta Package Tour', 'benar'),
(13, 3, 8, 'Muller &amp; Phipps Indonesia, Ltd.', 'Muller &amp; Phillips Indonesia, Ltd', 'salah'),
(14, 3, 9, 'Jakarta Lloyd, PN', 'Jakarta Lloyd, PN', 'benar'),
(15, 3, 10, 'Bhinneka Carakan', 'Bhinneka Carakhan', 'salah'),
(16, 3, 11, 'Jurusan Kriminologi Fisip', 'Jurusan Kriminologi Fisip', 'benar'),
(17, 3, 12, 'Bhumiamca Express', 'Bhumyamca Express', 'benar'),
(18, 3, 13, 'Sinar Matahari, toko', 'Sinar Matahari, toko', 'benar'),
(19, 3, 14, 'Dharma Wijaya, Ny', 'Dharma Wijaya, Ny', 'benar'),
(20, 3, 15, 'Cresival Bayer', 'Cresival Bayer', 'benar'),
(21, 3, 16, 'Phagoda Traiding Coy', 'Phagoda Trading Coy', 'salah'),
(22, 3, 17, 'Aneka Niaga, CV', 'Aneka Niaga, CV', 'benar'),
(23, 3, 18, 'Hotel Ambarukmo', 'Hotel Ambarukmo', 'benar'),
(24, 3, 19, 'Samudera Beach Hotel', 'Samudera Beach Hotel', 'benar'),
(25, 3, 20, 'Kerta Niaga', 'Kerta Niaga', 'benar'),
(26, 3, 21, 'Laxmi Store', 'Laxmistore', 'salah'),
(27, 3, 22, 'Apotik Tunggal ', 'Apotik Tunggal ', 'benar'),
(28, 3, 23, 'Percetakan Tristar', 'Percetakan Tristar', 'benar'),
(29, 3, 24, 'Amicitia', 'Amicitie', 'salah'),
(30, 3, 25, 'Bapindo', 'Bappindo', 'salah'),
(31, 3, 26, 'Aneka Bhakti ', 'Aneka Bhakti ', 'benar'),
(32, 3, 27, 'Puslitbang', 'Puslitdik', 'salah'),
(33, 3, 28, 'Perusahaan &quot;Mitra Batik&quot;', 'Perusahaan &quot;Mitra Baik&quot;', 'benar'),
(34, 3, 29, 'PT Raja Farma', 'PT Raja Pharma', 'salah'),
(35, 3, 30, 'Ciptomangunkusumo, r.s', 'Ciptomangunkusumo, dr', 'salah'),
(36, 3, 31, 'Pekan Olaharaga Nasional IX', 'Pekan Olaharaga Nasional IX', 'benar'),
(37, 3, 32, 'Jl. Raya Jendral Soedirman', 'Jl. Raya Jendral Soedirman', 'benar'),
(38, 3, 33, 'Kesambi Indah, PT', 'Kosambi Indah, PT', 'salah'),
(39, 3, 34, 'Nyonya Chairuddin Thaib', 'Nyonya Chairuddin Thaib', 'benar'),
(40, 3, 35, 'Tn. Sisingamangaraja', 'Tn. Sisingamangaraja', 'benar'),
(41, 3, 36, 'Koperasi Batik Indonesia', 'Koperasi Batik Indonesia', 'benar'),
(42, 3, 37, 'K.B.N &quot;Antara&quot;', 'K. BN &quot;Antara&quot;', 'salah'),
(43, 3, 38, 'Mask. Pel. &quot;Samudera&quot;', 'Mask. Pel. &quot;Samudera&quot;', 'benar'),
(44, 3, 39, 'Mask. Perdag. Omega Motor', 'mask. Perdag. Omega Motor', 'salah'),
(45, 3, 40, 'Mesjid Agung Al-Azhar', 'Mesjid Agung Al Azhar', 'salah'),
(46, 3, 41, 'Adhi Karya, Persero', 'Adhi Karya, Persero', 'benar'),
(47, 3, 42, 'Pelayaran Nasional Indonesia', 'Pelayaran Nat\'l Indonesia', 'salah'),
(48, 3, 43, 'Perkebunan Berkat Budi', 'Perkebunan Berkat Budi', 'benar'),
(49, 3, 44, 'Nupiksa Yasa, Perindra', 'Nupikca Yasa, Perindra', 'salah'),
(50, 3, 45, 'Pioneer Trading Cp. Ltd', 'Pioneer Trading Coy, Ltd', 'salah'),
(51, 3, 46, 'Ambasador, rumah makan', 'Ambasador, rumah makan', 'benar'),
(52, 3, 47, 'S.M.P.N XIV', 'S.M.P.N XVI', 'salah'),
(53, 3, 48, 'Sinat Utama, PT', 'Utama Sinat, PT', 'salah'),
(54, 3, 49, 'Sinar Harapan, s.k', 'Sinar Harapan, f.a.', 'salah'),
(55, 3, 50, 'Siemens Indonesia', 'Siemens Indonesia', 'benar'),
(56, 3, 51, 'P.T. Sayogya', 'P.T. Sayoga', 'salah'),
(57, 3, 52, 'Kebayoran Serview, biro teknik', 'Kebayoran Secvice, biro technik', 'salah'),
(58, 3, 53, 'Kaltimex, C.V.', 'Kaltimex, C.V.', 'benar'),
(59, 3, 54, 'B.B. Technikasari, PT', 'B.B. Tehnikasari, PT', 'salah'),
(60, 3, 55, 'Meredeka Press, N.V', 'Merdeka Pres, C.V.', 'salah'),
(61, 3, 56, 'Grafika Indonesia, Publ.', 'Grafika Indonesia, Publ.', 'benar'),
(62, 3, 57, 'Neil Aemstrong, Apollo', 'Neil Amstrong, Apollo', 'salah'),
(63, 3, 58, 'Pa Van der Steur, Jay', 'Pa Van der Steur, Jay', 'benar'),
(64, 3, 59, 'Mask. Penerbangan Panam', 'Mask. Penerbangan Panama', 'salah'),
(65, 3, 60, 'Kecap Benteng Cap Klenci', 'Kecap Benteng Cap Kelinci', 'salah'),
(66, 3, 61, 'Art Gallery &quot;Kendari&quot;', 'Art Gallery &quot;Kendari&quot;', 'benar'),
(67, 3, 62, 'Firma Cipay, exim', 'Firma Cipay, exim', 'benar'),
(68, 3, 63, 'Budidharma, pers. angkutan', 'Budidharma, pers. angkutan', 'benar'),
(69, 3, 64, 'P.N. Budi Bhakti, distributors', 'P.N. Budi Bhakti, distributors', 'benar'),
(70, 3, 65, 'Asuransi kerugian Eka Nusa, PN', 'Asuransi kerugian Eka Nusa', 'salah'),
(71, 3, 66, 'Tri Tunggal Ika, eksporitir', 'Tri Tunggal Ika, eksporitir', 'benar'),
(72, 3, 67, 'Uni Shipping Agency', 'Uni Shopping Agency', 'salah'),
(73, 3, 68, 'Arafat, PT Pelayaran', 'Arafat, PT Pelayaran', 'benar'),
(74, 3, 69, 'PT Harimau Putih Trading', 'PT Harimau Putih Trading', 'benar'),
(75, 3, 70, '&quot;Pengantar Psikologi&quot;', '&quot;Pengantar Fisiologi&quot;', 'salah'),
(76, 3, 71, '&quot;Percikan Filsafat&quot;', '&quot;Percikan Filsafat&quot;', 'benar'),
(77, 3, 72, '&quot;Nagasasra dan Sabukinten&quot;', '&quot;Nagasastra dan Sabukinten&quot;', 'salah'),
(78, 3, 73, 'Kerajaan Singasari', 'Kerajaan Singosari', 'salah'),
(79, 3, 74, 'Ramayana Store', 'Ramayana Story', 'salah'),
(80, 3, 75, '&quot;Indonesia Raya&quot;, s.k.', '&quot;Indonesia Raya&quot;, s.k.', 'benar'),
(81, 3, 76, '&quot;Indonesia Raya&quot;, s.k.', '&quot;Indonesia Raya&quot;, s.k.', 'benar'),
(82, 3, 77, 'Jawa Barat 585.000 ha', 'Jawa Barat 585.000 hm', 'salah'),
(83, 3, 78, 'Penyewa kontrak 258.525', 'Penyewa kontrak 258.252', 'salah'),
(84, 3, 79, 'Kendaraan sepeda 117.698', 'Kendaraan speda 117.698', 'salah'),
(85, 3, 80, 'Ratu luwes Miss Indonesia', 'Ratu luwes Miss Indonesia', 'benar'),
(86, 3, 81, 'Penrbit Yayasan Bentara Rakyat', 'Penerbit Yayasan Bentara Rakyat', 'salah'),
(87, 3, 82, 'b.t. Kebayoran Service', 'b.t. Kemayoran Service', 'salah'),
(88, 3, 83, 'Telp. PIO 81635', 'Tilp. PIO 81635', 'salah'),
(89, 3, 84, 'Tekstil Import 87.875', 'Tekstil Import 81.875', 'salah'),
(90, 3, 85, 'T.B. Bunga Bersemi', 'T.B. Bunga Bersinar', 'salah'),
(91, 3, 86, 'PT. Saksamajaya', 'PT. Saksamajaya', 'benar'),
(92, 3, 87, 'Achmad Matcik Brothers', 'Achmad Matcik Brothers', 'benar'),
(93, 3, 88, 'Langsing Sports', 'Langsing Sports', 'benar'),
(94, 3, 89, 'Perusahaan Susu &quot;Agam&quot;', 'Perusahaan Susu &quot;Agam&quot;', 'benar'),
(95, 3, 90, 'All Indonesian Final', 'All Indonesian Final', 'benar'),
(96, 3, 91, 'Allied Artists of Indonesia', 'Allied Artists of Indonesia', 'benar'),
(97, 3, 92, 'Pabrik sabun &quot;Abadiat&quot;', 'Pabrik sabun &quot;Abadiati&quot;', 'salah'),
(98, 3, 93, 'Rapih Taylor', 'Rapih Taylor', 'benar'),
(99, 3, 94, 'Biro Yayasan Teknik', 'Biro Yayasan Technik', 'salah'),
(100, 3, 95, 'Salon &quot;Cantik&quot;', 'Salon &quot;Cantik&quot;', 'benar'),
(101, 3, 96, 'PDN Bhudi Bhakti', 'PDN Bhudi Bhakti', 'benar'),
(102, 3, 97, 'Radio El-Shinta', 'Radio El-Shinta', 'benar'),
(103, 3, 98, 'Jakarta Riding Club', 'Jakarta Rading Club', 'salah'),
(104, 3, 99, 'Alpha Catering', 'Alfa Catering', 'salah'),
(105, 3, 100, 'Galangan Kapal Nasional Ind.', 'Galangan Kapal National Ind.', 'salah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul_4`
--

CREATE TABLE `modul_4` (
  `id` int(11) NOT NULL,
  `soal_id` int(11) NOT NULL,
  `nomor_soal` int(11) NOT NULL,
  `teks_soal` text NOT NULL,
  `kunci_jawaban` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `modul_4`
--

INSERT INTO `modul_4` (`id`, `soal_id`, `nomor_soal`, `teks_soal`, `kunci_jawaban`) VALUES
(1, 4, 1, 'Seorang anak mempunyai 12 pensil. 6 pensil dipinjam temannya. Berapa pensil sisanya ?', '6'),
(2, 4, 2, 'Berapa jumlah seluruh siswa di kelas bila siswanya ada 16 orang dan siswinya ada 18 orang?', '34'),
(3, 4, 3, 'Seorang petani mempunyai 8 ekor ayam. Ia membeli lagi 5 ekor. Berapa ekor ayamnya sekarang?									', '13'),
(4, 4, 4, 'Seorang penjahit menyelesaikan 7 baju sehari. Berapa baju dapat diselesaikan dalam 6 hari									\r\n', '42'),
(5, 4, 5, 'Suatu rumah berdiri di atas tanah yang panjangnya 21 meter dan lebarnya 12 meter. Berapa meter persegi luas tanah rumah itu?									\r\n', '252'),
(6, 4, 6, 'Seorang anak membeli permen seharga Rp. 250,-. Berapa permen diperolehnya kalau 3 permen harganya Rp. 50,-?									\r\n', '15'),
(7, 4, 7, 'Perjalanan ke sekolah biasanya memakan waktu 35 menit, tetapi karena macet perlu waktu 1 jam 10 menit. Berapa menit lebih lama perjalanan itu?									\r\n', '35'),
(8, 4, 8, 'Seorang ibu menggunakan seperempat (1/4) waktu kerjanya  untuk memasak. Bila waktu kerjanya 14 jam sehari, berapa jam sehari ibu ini memasak?									\r\n', '3,50'),
(9, 4, 9, 'Secarik kain yang panjangnya 9 yard (1 yard = 90 cm) dipotong 7 kaki (1 kaki = 30 cm). Berapa cm sisa panjang kain itu?									\r\n', '600'),
(10, 4, 10, 'Seorang pegawai mendapat upah Rp. 1250,- sehari. Ia telah bekerja selama lima hari dan mendapat tambahan uang lembur Rp. 1800,- untuk lima hari tersebut. Berapa upah seluruhnya?									\r\n', '8050'),
(11, 4, 11, 'Berapa jam dibutuhkan sebuah mobil untuk menempuh jarak 400 km, bila kecepatannya 600 km/ jam?									\r\n', '6,67'),
(12, 4, 12, 'Delapan orang menyelesaikan pengecatan sebuah gedung dalam empat hari. Berapa orang dibutuhkan untuk mengecat gedung dalam 2 hari?									\r\n', '16'),
(13, 4, 13, 'Seorang pegawai berpenghasilan Rp. 150.000,- per bulan. 2% dari jumlah itu untuk melunasi pajak. Berapa besar pajak yang dibayarnya dalam satu tahun?									\r\n', '36000'),
(14, 4, 14, 'Suatu sekolah menerima pendaftaran calon murid sebanyak 1100 anak. Namun yang dapat diterima setelah diseleksi hanya 35%. Berapa anak yang ditolak masuk?									\r\n', '715'),
(15, 4, 15, 'Seorang pedagang membeli sepeda bekas seharga Rp. 30.000,-. Ia menjual lagi dengan keuntungan 15%. Berapa harga penjualan sepeda itu?									\r\n', '34500'),
(16, 4, 16, 'Sebuah bak ikan berukuran 13,5 meter kubik. Bila lebar dan dalamnya sama-sama 1,5 meter, berapakah panjang bak itu?									\r\n', '6'),
(17, 4, 17, 'Ibu membeli 1 1/2 kg beras seharga Rp. 1.125,-. Berapa kg beras yang ibu peroleh dengan uang sebanyak Rp. 4.125,-?									\r\n', '6'),
(18, 4, 18, 'Seorang tukang memaan ubin yang berukuran 2 dm x 3 dm untuk sebuah ruangan yang luas lantainya 3 m x 4 m. Berapa banyak ubin yang diperlukan?									\r\n', '5,50'),
(19, 4, 19, 'Perbaikan sebuah rumah memperkerjakan 3 orang tukang. Mereka masing-masing dibayar Rp. 1.000,-; Rp. 1.250,-; Rp. 1.500,- per jam. Dalam sehari mereka bekerja selama 7 jam. Setelah selesai mereka dibayar Rp. 315.000,-. Berapa harikah yang diperlukan untuk mengerjakan rumah itu?									\r\n', '12'),
(20, 4, 20, 'Seorang anak menggunakan 1/8 dari uang sakunya untuk membeli alat tulis, dan tiga kali dari itu unutk jajan. Dari sisanya separuh ditabung, dan ia masih punya Rp. 1.600,-. Berapa uangnya semula?									\r\n', '6400');

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul_5`
--

CREATE TABLE `modul_5` (
  `id` int(11) NOT NULL,
  `soal_id` int(11) NOT NULL,
  `nomor_soal` int(11) NOT NULL,
  `kategori_setuju` varchar(45) NOT NULL,
  `pernyataan` text NOT NULL,
  `kategori_tidak_setuju` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `modul_5`
--

INSERT INTO `modul_5` (`id`, `soal_id`, `nomor_soal`, `kategori_setuju`, `pernyataan`, `kategori_tidak_setuju`) VALUES
(2, 5, 1, 'S;I;*;C', 'Mudah bergaul, ramah mudah setuju				;Mempercayai, percaya pada orang lain				\r\n;Petualang, suka mengambil resiko				\r\n;Penuh toleransi, menghormati orang lain				', 'S;I;C;C'),
(3, 5, 2, 'D;C;*;*', 'Yang penting adalah hasil					\r\n;Kerjakan dengan benar, ketepatan sangat penting					\r\n;Buat agar menyenangkan					\r\n;Kerjakan bersama-sama					\r\n', 'D;C;S;S'),
(4, 5, 3, '*;D;S;I', 'Pendidikan, kebudayaan					\r\n;Prestasi, penghargaan					\r\n;Keselamatan, keamanan					\r\n;Sosial, pertemuan kelompok					\r\n', 'C;D;S;*'),
(5, 5, 4, 'C;D;*;S', 'Lembut, tertutup 				\r\n;Pandangan ke masa depan, optimis				\r\n;Pusat perhatian, suka bersosialisasi				\r\n;Pendamai, pembawa ketenangan				\r\n', '*;D;I;S'),
(6, 5, 5, '*;D;S;I', 'Menahan diri, bisa hidup tanpa memiliki					\r\n;Membeli karena dorongan hasrat, impulsif			\r\n;Akan menunggu, tanpa tekanan;Akan membeli apa yang diinginkan					', 'C;D;S;*'),
(7, 5, 6, 'D;*;*;C', 'Mengambil kendali, pendekatan langsung	;Suka bergaul, antusias					;Mudah ditebak, konsisten					;Waspada, berhati-hati					', 'D;I;S;*'),
(8, 5, 7, 'I;*;*;*', 'Menyemangati orang lain				\r\n;Berusaha mencapai kesempurnaan				\r\n;Menjadi bagian dari kelompok				\r\n;Ingin menetapkan goal / tujuan				\r\n', 'I;C;S;*'),
(9, 5, 8, 'S;*;D;C', 'Bersahabat, mudah bergaul					\r\n;Unik, bosan pada rutinitas					\r\n;Aktif melakukan perubahan					\r\n;Ingin segala sesuatu akurat dan pasti					\r\n', '*;I;D;C'),
(10, 5, 9, 'D;S;I;*', 'Suka dikalahkan, ditundukkan					\r\n;Melaksanakan sesuai perintah, mengikuti pimpinan					\r\n;Mudah bergairah, riang					\r\n;Ingin keteraturan, rapi					\r\n', 'D;*;I;C'),
(11, 5, 10, 'C;S;*;D', 'Menjadi frustasi				\r\n;Memendam perasaan dalam hati				\r\n;Menyampaikan sudut pandang pribadi				\r\n;Berani menjadi oposisi				\r\n', 'C;S;I;D'),
(12, 5, 11, '*;C;I;D', 'Mengalah, tidak suka pertentangan					\r\n;Penuh dengan hal-hal kecil / detail					\r\n;Berubah pada menit-menit terakhir					\r\n;Mendesak / memaksa, agak kasar					\r\n', 'S;*;I;D'),
(13, 5, 12, 'D;S;I;C', 'Saya akan pimpin mereka 					\r\n;Saya akan ikut / mengikuti					\r\n;Saya akan pengaruhi / bujuk mereka						\r\n;Saya akan mendapatkan fakta-faktanya', '*;S;I;*'),
(14, 5, 13, 'I;D;S;*', 'Hidup / lincah, banyak bicara				\r\n;Cepat penuh keyakinan, tekad kuat				\r\n;Berusaha menjaga keseimbangan				\r\n;Berusaha patuh pada peraturan				\r\n', '*;D;S;C'),
(15, 5, 14, 'D;S;I;*', 'Ingin kemajuan / peningkatan					\r\n;Puas dengan keadaan / mudah puas					\r\n;Menunjukkan perasaan dengan terbuka					\r\n;Rendah hati / sederhana					\r\n', 'D;*;*;C'),
(16, 5, 15, 'S;D;I;*', 'Memikirkan orang lain dahulu					\r\n;Suka bersaing / kompetitif, suka tantangan					\r\n;Optimis, positif					\r\n;Sistematis, berpikir logis					\r\n', 'S;D;I;C'),
(17, 5, 16, 'C;D;I;S', 'Mengelola waktu dengan efesien				\r\n;Sering terburu-buru, merasa ditekan				\r\n;Hal-hal sosial adalah penting				\r\n;Suka menyelesaikan hal yang sudah dimulai				\r\n', '*;D;I;S'),
(18, 5, 17, 'C;I;S;D', 'Tenang, pendiam					\r\n;Gembira, riang					\r\n;Menyenangkan, baik hati					\r\n;Tegas, berani					\r\n', 'C;I;*;D'),
(20, 5, 18, 'S;*;D;C', 'Menyenangkan oran lain, ramah					\r\n;Tertawa lepas, hidup					\r\n;Pemberani, tegas					\r\n;Tenang, pendiam					\r\n', 'S;I;D;C'),
(21, 5, 19, 'S;I;*;*', 'Menolak perubahan yang mendadak				\r\n;Cenderung terlalu banyak berjanji				\r\n;Mundur apabila berada di bawah tekanan				\r\n;Tidak takut untuk berkelahi				\r\n', '*;I;D;C'),
(22, 5, 20, 'S;C;I;D', 'Menyediakan waktu untuk orang lian					\r\n;Merencanakan masa depan, bersiap-siap					\r\n;Menuju petualangan baru					\r\n;Menerima penghargaan atas pencapaian tujuan/sasaran					\r\n', 'S;*;I;D'),
(23, 5, 21, '*;I;S;*', 'Ingin wewenang / kekuasaan					\r\n;Ingin kesempatan baru					\r\n;Menghindari perselisihan / konflik apapun					\r\n;Ingin arahan yang jelas					\r\n', 'D;*;S;C'),
(24, 5, 22, 'I;S;C;D', 'Penyemangat / pendukung yang baik				\r\n;Pendengar yang baik				\r\n;Penganalisa yang baik				\r\n;Pendelegasi yang baik, pandai membagi tugas				\r\n', 'I;S;C;D'),
(25, 5, 23, '*;C;I;S', 'Peraturan perlu diuji / ditantang					\r\n;Peraturan membuat menjadi adil					\r\n;Peraturan membuat menjadi membosankan					\r\n;Peraturan membuat menjadi aman					\r\n', 'D;*;I;S'),
(26, 5, 24, '*;I;D;C', 'Dapat dipercaya dan diandalkan					\r\n;Kreatif, unik					\r\n;Berorientasi pada hasil, intinya					\r\n;Memegang teguh standar yang tinggi, akurat					\r\n', 'S;I;*;*');

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul_6`
--

CREATE TABLE `modul_6` (
  `id` int(11) NOT NULL,
  `soal_id` int(11) NOT NULL,
  `nomor_soal` int(11) NOT NULL,
  `pernyataan` text NOT NULL,
  `kategori` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `modul_6`
--

INSERT INTO `modul_6` (`id`, `soal_id`, `nomor_soal`, `pernyataan`, `kategori`) VALUES
(2, 7, 1, 'Saya seorang pekerja keras;Saya tidak suka uring-uringan;', 'G;E'),
(3, 7, 2, 'Saya suka menghasilkan pekerjaan yang lebih baik daripada orang lain\r\n;Saya akan tetap menangani suatu pekerjaan sampai selesai\r\n', 'A;N'),
(4, 7, 3, 'Saya suka menunjukkan pada orang lain cara melakukan sesuatu\r\n;Saya ingin berusaha sebaik mungkin\r\n', 'P;A'),
(5, 7, 4, 'Saya suka melucu\r\n;Saya senang memberitahu orang lain hal-hal yang harus dikerjakan\r\n', 'X;P'),
(6, 7, 5, 'Saya suka bergabung dengan kelompok\r\n;Saya senang diperhatikan oleh kelompok\r\n', 'B;X'),
(7, 7, 6, 'Saya suka menjalin hubungan pribadi yang akrab\r\n;Saya suka berteman dengan kelompok\r\n', 'O;B'),
(8, 7, 7, 'Saya dapat cepat berubah jika merasa perlu\r\n;Saya berusaha melakukan hal-hal yang berbeda\r\n', 'Z;O'),
(9, 7, 8, 'Saya suka menyerang kembali jika benar-benar disakiti\r\n;Saya suka melakukan hal-hal yang baru dan berbeda\r\n', 'K;Z'),
(10, 7, 9, 'Saya ingin agar atasan saya menyukai saya\r\n;Saya suka menegur orang lain jika mereka melakukan kesalahan\r\n', 'F;K'),
(11, 7, 10, 'Saya suka mengikuti petunjuk-petunjuk yang diberikan kepada saya\r\n;Saya suka menyenangkan orang-orang yang menjadi atasan saya\r\n', 'W;F'),
(12, 7, 11, 'Saya berusaha keras sekali\r\n;Saya seorang yang teratur. Saya meletakkan segala sesuatu pada tempatnya\r\n', 'G;C'),
(13, 7, 12, 'Saya dapat membuat orang lain melakukan apa yang saya inginkan\r\n;Saya tidak mudah marah\r\n', 'L;E'),
(14, 7, 13, 'Saya suka memberitahu kelompok, hal-hal yang harus mereka kerjakan\r\n;Saya selalu bertahan pada suatu pekerjaan sampai selesai\r\n', 'P;N'),
(15, 7, 14, 'Saya ingin menjadi orang yang penuh gairah dan menarik\r\n;Saya ingin menjadi orang yang sangat berhasil\r\n', 'X;A'),
(16, 7, 15, 'Saya ingin menjadi bagian dalam kelompok\r\n;Saya suka membantu orang lain mengambil keputusan\r\n', 'B;P'),
(17, 7, 16, 'Saya cemas bila seseorang tidak menyukai saya\r\n;Saya ingin agar orang lain memperhatikan saya\r\n', 'O;X'),
(18, 7, 17, 'Saya suka mencoba hal-hal baru\r\n;Saya lebih suka bekerja bersama orang lain daripada sendiri\r\n', 'Z;B'),
(19, 7, 18, 'Kadang-kadang saya menyalahkan orang lain jika ada yang tidak beres\r\n;Saya mersasa terganggu jika seseorang tidak menyukai saya\r\n', 'K;O'),
(20, 7, 19, 'Saya suka menyenangkan orang lain yang menjadi atasan saya\r\n;Saya senang mencoba pekerjaan yang baru dan berbeda\r\n', 'F;Z'),
(21, 7, 20, 'Saya menyukai petunjuk-petunjuk terperinci untuk melaksanakan tugas\r\n;Saya suka memberitahu orang lain apabila mereka menjengkelkan\r\n', 'W;K'),
(22, 7, 21, 'Saya selalu berusaha keras\r\n;Saya selalu melaksanakan setiap langkah dengan sangat hati-hati\r\n', 'G;D'),
(23, 7, 22, 'Saya seorang pemimpin yang baik\r\n;Saya menata pekerjaan dengan baik\r\n', 'L;C'),
(24, 7, 23, 'Saya mudah marah\r\n;Saya lambat dalam mengambil keputusan\r\n', 'I;E'),
(25, 7, 24, 'Saya suka mengerjakan beberapa tugas pada saat yang bersamaan\r\n;Bila berada  dalam satu kelompok, saya suka berdiam diri\r\n', 'X;N'),
(26, 7, 25, 'Saya senang sekali bila diundang\r\n;Saya ingin melakukan sesuatu lebih baik dari pada orang lain\r\n', 'B;A'),
(27, 7, 26, 'Saya suka menjalin hubungan pribadi yang akrab\r\n;Saya suka memberi nasihat pada orang lain\r\n', 'O;P'),
(28, 7, 27, 'Saya suka melakukan hal-hal yang baru dan berbeda\r\n;Saya suka menceritakan bagaimana saya berhasil dalam melakukan sesuatu\r\n', 'Z;X'),
(29, 7, 28, 'Apabila pendapat saya benar, saya suka mempertahankannya\r\n;Saya ingin menjadi bagian dari suatu kelompok\r\n', 'K;B'),
(30, 7, 29, 'Saya  tidak mau berbeda dari orang lain\r\n;Saya berusaha akrab dengan orang lain\r\n', 'F;O'),
(31, 7, 30, 'Saya senang diberitahu bagaimana melakukan suatu pekerjaan\r\n;Saya mudah bosan\r\n', 'W;Z'),
(32, 7, 31, 'Saya bekerja keras\r\n;Saya banyak berpikir dan membuat rencana\r\n', 'G;R'),
(33, 7, 32, 'Saya memimpin kelompok\r\n;Detail (hal-hal kecil) menarik buat saya\r\n', 'L;D'),
(34, 7, 33, 'Saya membuat keputusan dengan mudah dan cepat\r\n;Saya menyimpan barang-barang secara rapi dan teratur\r\n', 'I;C'),
(35, 7, 34, 'Saya membuat keputusan dengan mudah dan cepat\r\n;Saya jarang marah atau sedih\r\n', 'T;E'),
(36, 7, 35, 'Saya ingin menjadi bagian dalam kelompok\r\n;Saya ingin melakukan hanya satu pekerjaan pada satu waktu\r\n', 'B;N'),
(37, 7, 36, 'Saya berusaha berteman secara akrab\r\n;Saya berusaha sangat keras untuk menjadi yang terbaik\r\n', 'O;A'),
(38, 7, 37, 'Saya suka gaya terbaru dalam hal pakaian dan mobil\r\n;Saya suka bertanggung jawab atas orang lain\r\n', 'Z;P'),
(39, 7, 38, 'Saya senang berdebat\r\n;Saya suka mendapat perhatian\r\n', 'K;X'),
(40, 7, 39, 'Saya suka menyenangkan orang yang menjadi atasan saya\r\n;Saya tertarik untuk menjadi bagian dari kelompok\r\n', 'F;B'),
(41, 7, 40, 'Saya suka mengikuti peraturan dengan hati-hati\r\n;Saya suka orang lain mengenal saya dengan baik\r\n', 'W;O'),
(42, 7, 41, 'Saya berusaha keras sekali\r\n;Saya sangat ramah\r\n', 'G;S'),
(43, 7, 42, 'Orang lain berpendapat bahwa saya pemimpin yang baik\r\n;Saya berpikir hati-hati dan lama\r\n', 'L;R'),
(44, 7, 43, 'Saya sering memanfaatkan kesempatan\r\n;Saya suka cerwet mengenai hal-hal yang kecil\r\n', 'I;D'),
(45, 7, 44, 'Orang lain berpendapat bahwa saya bekerja cepat\r\n;Orang lain berpendapat bahwa saya menyimpan segala sesuatu secara teratur dan rapi\r\n', 'T;C'),
(46, 7, 45, 'Saya menyukai permainan dan olah raga\r\n;Saya sangat menyenangkan\r\n', 'V;E'),
(47, 7, 46, 'Saya senang bila orang lain bersikap akrab dan ramah\r\n;Saya selalu berusaha menyelesaikan sesuatu yang telah saya mulai\r\n', 'O;N'),
(48, 7, 47, 'Saya suka bereksperimen dan mencoba hal-hal baru\r\n;Saya suka melaksanakan pekerjaan sulit dengan baik\r\n', 'Z;A'),
(49, 7, 48, 'Saya suka diperlakukan secara adil\r\n;Saya suka memberitahu orang lain cara mengerjakan sesuatu\r\n', 'K;P'),
(50, 7, 49, 'Saya suka melakukan hal-hal yang diharapkan dari saya\r\n;Saya suka mendapat perhatian\r\n', 'F;X'),
(51, 7, 50, 'Saya suka petunjuk-petunjuk terperinci untuk melaksanakan suatu tugas\r\n;Saya senang berada bersama orang lain\r\n', 'W;B'),
(52, 7, 51, 'Saya selalu berusaha melakukan pekerjaan secara sempurna\r\n;Orang mengatakan bahwa saya hampir tidak pernah lelah\r\n', 'G;V'),
(53, 7, 52, 'Saya tipe seorang pemimpin\r\n;Saya mudah berteman\r\n', 'L;S'),
(54, 7, 53, 'Saya memanfaatkan kesempatan\r\n;Saya banyak sekali berpikir\r\n', 'I;R'),
(55, 7, 54, 'Saya bekerja dengan tempo yang cepat dan mantap\r\n;Saya senang menangani pekerjaan detail\r\n', 'T;D'),
(56, 7, 55, 'Saya memiliki banyak tenaga untuk permainan dan olah raga\r\n;Saya menyimpan segala sesuatu secara rapi dan teratur\r\n', 'V;C'),
(57, 7, 56, 'Saya bergaul dengan semua orang\r\n;Saya berwatak tenang\r\n', 'S;E'),
(58, 7, 57, 'Saya ingin bertemu oran-orang baru dan melakukan hal-hal baru\r\n;Saya selalu ingin menyelesaikan pekerjaan yang telah saya mulai\r\n', 'Z;N'),
(59, 7, 58, 'Saya biasanya suka mempertahankan keyakinan saya\r\n;Saya biasanya suka kerja keras\r\n', 'K;A'),
(60, 7, 59, 'Saya menyukai saran-saran dan orang-oran yang saya kagumi\r\n;Saya suka bertanggung jawab terhadap orang lain\r\n', 'F;P'),
(61, 7, 60, 'Saya membiarkan orang lain mempengaruhi diri saya secara kuat\r\n;Saya suka mendapat banyak perhatian\r\n', 'W;X'),
(62, 7, 61, 'Saya biasanya bekerja keras sekali\r\n;Saya biasanya bekerja cepat\r\n', 'G;T'),
(63, 7, 62, 'Apabila saya berbicara, kelompok menyimak\r\n;Saya terampil menggunakan peralatan\r\n', 'L;V'),
(64, 7, 63, 'Saya lambat dalam berteman\r\n;Saya lambat dalam mengambil keputusan\r\n', 'I;S'),
(65, 7, 64, 'Saya biasanya makan dengan cepat\r\n;Saya senang membaca\r\n', 'T;R'),
(66, 7, 65, 'Saya menyukai pekerjaan yang membuat saya banyak bergerak\r\n;Saya menyukai pekerjaan yang harus saya kerjakan secara hati-hati\r\n', 'V;D'),
(67, 7, 66, 'Saya berteman dengan sebanyak mungkin orang\r\n;Saya dapat menemukan sesuatu yang telah saya sisihkan\r\n', 'S;C'),
(68, 7, 67, 'Saya merencana jauh di muka\r\n;Saya selalu menyenangkan\r\n', 'R;E'),
(69, 7, 68, 'Saya sangat bangga akan nama baik saya\r\n;Saya suka menangani suatu permasalahan sampai tepecahkan\r\n', 'K;N'),
(70, 7, 69, 'Saya suka menyenangakan oran-orang yang saya kagumi\r\n;Saya ingin berhasil\r\n', 'F;A'),
(71, 7, 70, 'Saya suka orang-orang lain membuat keputusan-keputusan untuk kelompok\r\n;Saya suka membuat keputusan-keputusan untuk kelompok\r\n', 'W;P'),
(72, 7, 71, 'Saya selalu berusaha sangat keras\r\n;Saya membuat keputusan secara mudah dan cepat\r\n', 'G;I'),
(73, 7, 72, 'Kelompok biasanya melaksanakan keinginan saya\r\n;Saya biasa tergesa-gesa\r\n', 'L;T'),
(74, 7, 73, 'Saya sering merasa lelah\r\n;Saya lambat dalam membuat keputusan\r\n', 'I;V'),
(75, 7, 74, 'Saya bekerja cepat\r\n;Saya mudah berteman\r\n', 'T;S'),
(76, 7, 75, 'Saya biasanya bersemangat atau bergairah\r\n;Saya menggunakan banyak waktu untuk berpikir\r\n', 'V;R'),
(77, 7, 76, 'Saya sangat ramah terhadap orang lain\r\n;Saya menyukai pekerjaan yang menuntuk ketelitian\r\n', 'S;D'),
(78, 7, 77, 'Saya banyak berpikir dan merencana\r\n;Saya menyimpan segala sesuatu pada tempatnya\r\n', 'R;C'),
(79, 7, 78, 'Saya menyukai pekerjaan yang menuntuk hal-hal yang mendetail\r\n;Saya tidak cepat marah\r\n', 'D;E'),
(80, 7, 79, 'Saya suka mengikuti orang-orang yang saya kagumi\r\n;Saya selalu menyelesaikan pekerjaan yang telah saya mulai\r\n', 'F;N'),
(81, 7, 80, 'Saya menyukai petunjuk-petunjuk yang jelas \r\n;Saya suka bekerja keras\r\n', 'W;A'),
(82, 7, 81, 'Saya mengejar hal-hal yang menjadi keinginan saya\r\n;Saya seorang pemimpin yang baik\r\n', 'G;L'),
(83, 7, 82, 'Saya membuat orang lain bekerja keras\r\n;Saya suka bersenang-senang\r\n', 'L;I'),
(84, 7, 83, 'Saya membuat keputusan dengan cepat\r\n;Saya berbicara cepat\r\n', 'I;T'),
(85, 7, 84, 'Saya biasanya bekerja secara tergesa-gesa\r\n; Saya berolah raga secara teratur\r\n', 'T;V'),
(86, 7, 85, 'Saya tidak suka bertemu orang-orang lain\r\n;Saya cepat lelah\r\n', 'V;S'),
(87, 7, 86, 'Saya berteman dengan banyak sekali orang\r\n;Saya menggunakan banyak waktu untuk berpikir\r\n', 'S;R'),
(88, 7, 87, 'Saya suka bekerja dengan teori\r\n;Saya suka melaksanakan pekerjaan detail\r\n', 'R;D'),
(89, 7, 88, 'Saya suka melaksanakan pekerjaan detail\r\n;Saya suka mengatur pekerjaan saya\r\n', 'D;C'),
(90, 7, 89, 'Saya meletakkan segala sesuatu pada tempatnya\r\n;Saya selalu menyangkan\r\n', 'C;E'),
(91, 7, 90, 'Saya senang diberitahu hal-hal yang harus saya kerjakan\r\n;Saya harus menyelesaikan apa yang telah saya mulai\r\n', 'W;N');

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul_7`
--

CREATE TABLE `modul_7` (
  `id` int(11) NOT NULL,
  `soal_id` int(11) NOT NULL,
  `nomor_soal` int(11) NOT NULL,
  `pernyataan` text NOT NULL,
  `kategori` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `modul_7`
--

INSERT INTO `modul_7` (`id`, `soal_id`, `nomor_soal`, `pernyataan`, `kategori`) VALUES
(1, 8, 1, 'Saya tidak akan menegur pelanggar-pelanggar peraturan bila saya merasa pasti bahwa tidak ada satu orangpun yang mengetahui tentang pelanggar-pelanggar tersebut												;Bila saya mengumumkan suatu keputusan yang kurang menyenangkan, saya akan menjelaskan kepada bawahan saya bahwa keputusan ini dibuat oleh direktur							', 'A;B'),
(2, 8, 2, 'Bila ada seorang karyawan yang hasil kerjanya selalu tidak memuaskan saya, saya akan menunggu suatu kesempatan untuk memindahkannya dan bukan untuk memecatnya							;Bila ada bawahan saya yang dikucilkan dari kelompok kerjanya, saya akan mencari jalan agar orang lain dapat berteman dengannya							', 'A;B'),
(3, 8, 3, 'Bila direktur memberikan perintah yang kurang menyenangkan, saya pikir adalah cukup bijaksana bila saya menyebutkan namanya dan bukan nama saya							;Bila biasanya membuat keputusan-keputusan sendiri dan menyampaikannya kepada bawahan saya							\r\n', 'A;B'),
(4, 8, 4, 'Bila saya ditegur oleh atasan saya, saya akan memanggil semua bawahan saya dan mengatakan semua teguran tersebut kepada mereka;Saya selalu memberikan tugas-tugas yang sangat sulit kepada karyawan-karyawan yang paling berpengalaman', 'A;B'),
(5, 8, 5, 'Saya selalu melakukan diskusi-diskusi untuk mencapai kata sepakat							\r\n;Saya selalu menganjurkan kepada bawahan saya untuk memberikan usul-usul, tetapi kadang-kadang saya langsung mengambil tindakan tertentu', 'A;B'),
(6, 8, 6, 'Seringkali saya lebih mementingkan tugas daripada saya sendiri							\r\n;Saya mengijinkan bawahan-bawahan saya untuk ikut serta dalam mengambil keputusan							\r\n', 'A;B'),
(8, 8, 8, 'Bila saya mengumumkan suatu keputusan yang kurang menyenangkan, saya akan menjelaskan kepada bawahan saya bahwa keputusan ini dibuat oleh direktur							\r\n;Saya mengijinkan bawahan-bawahan saya untuk ikut serta di dalam pengambilan keputusan, tetapi sayapun menyediakan sesuatu yang jitu sebagai keputusan terakhir							\r\n', 'A;B'),
(9, 8, 9, 'Saya akan memberikan tugas-tugas yang sulit kepada bawahan saya yang belum berpengalaman, tetapi bila mereka memperoleh kesukaran, saya akan mengambil alih tanggung jawab mereka							\r\n;Bila jumlah dan mutu hasil kerja bagian saya tidak memuaskan, saya menjelaskan kepada bawahan-bawahab saya bahwa direktur merasa kecewa. Oleh karena itu mereka harus memperbaiki mutu kerja mereka							\r\n', 'A;B'),
(10, 8, 10, 'Saya merasa bahwa dengan bekerja keras untuk bawahan saya, mereka akan menyukai saya							\r\n;Saya membiarkan orang lain menangani tugas mereka masing-masing, walaupun mereka tidak membuat banyak kesalahan							\r\n', 'A;B'),
(11, 8, 11, 'Saya menunjukkan minat saya terhadap kehidupan pribadi bawahan-bawahan saya, karena sayapun mengharapkan mereka berbuat seperti itu kepada saya							\r\n;Saya merasa bahwa bawahan-bawahan saya tidak perlu mengerti mengapa mereka mengerjakan sesuatu hal, sejauh mereka mengerjakan hal tersebut							\r\n', 'A;B'),
(12, 8, 12, 'Saya percaya bahwa bawahan-bawahan yang tidak disiplin tidak akan memperbaiki jumlah atau mutu kerja mereka dalam jangka waktu yang panjang							\r\n;Bila menghadapi masalah yang sulit, saya berusaha untuk mencapai pemecahan yang dapat diterima oleh sebagian besar orang							\r\n', 'A;B'),
(13, 8, 13, 'Bila beberapa bawahan saya merasa tida berbahagia, saya akan mencoba melakukan sesuatu untuk mengatasi hal tersebut							\r\n;Saya berusaha bekerja sebaik mungkin dan memberikan ide-ide pengembangan pada pimpinan							\r\n', 'A;B'),
(14, 8, 14, 'Saya menyetujui kenaikan tunjangan-tunjangan untuk staf dan karyawan							\r\n;Saya mendukung bawahan saya yang ingin meningkatkan pengetahuan tentang pekerjaan dan perusahaan, walaupun hal itu sebenarnya belum diperlukan untuk kedudukan mereka sekarang							\r\n', 'A;B'),
(15, 8, 15, 'Saya membiarkan orang lain menangani tugas mereka masing-masing, walaupun mereka membuat banyak kesalahan							\r\n;Saya membuat keputusan-keputusan sendiri, tetapi saya akan mempertimbangkan usul-usul dan bawahan-bawahan saya							\r\n', 'A;B'),
(16, 8, 16, 'Bila ada bawahan saya yang dikucilkan dari kelompok kerjanya, saya akan mencari cara agar orang lain dapat berteman dengannya							\r\n;Bila seorang karyawan tidak sanggup menyelesaikan tugasnya, saya akan membantu dia untuk menyelesaikan tugas tersebut							\r\n', 'A;B'),
(17, 8, 17, 'Saya percaya bahwa penerapan disiplin merupakan contoh untuk karyawan-karyawan lain							\r\n;Saya merasa saya lebih mementingkan tugas daripada diri saya sendiri							\r\n						\r\n', 'A;B'),
(18, 8, 18, 'Saya mencela pembicaraan-pembicaraan yang tidak perlu di antara bawahan-bawahan saya, selama mereka bekerja							\r\n;Saya menyetujui kenaikan tunjangan-tunjangan untuk staf dan karyawan							\r\n', 'A;B'),
(19, 8, 19, 'Saya selalu memperhatikan keterlambatan dan kemangkiran bawahan saya							\r\n;Saya percaya bahwa serikat-serikat buruh akan mencoba meruntuhkan kewibawaan pimpinan perusahaan							\r\n', 'A;B'),
(20, 8, 20, 'Kadang-kadang saya merasa bahwa apa yang dikeluhkan oleh serikat buruh bukanlah masalah yang yang mendasar							\r\n;Saya merasa bahwa keluhan-keluhan tidak dapat dicegah dan saya akan berusaha untuk menghilangkan keluhan tersebut							\r\n', 'A;B'),
(21, 8, 21, 'Adalah penting bagi saya untuk memperoleh penghargaan atas ide-ide saya yang baik							\r\n;Saya mengemukakan pendapat-pendapat saya dimuka umum hanya bila saya merasa bahwa orang lain akan setuju dengan saya							\r\n', 'A;B'),
(22, 8, 22, 'Bila ada tugas yang mendesak, walaupun semua peralatannya sudah disediakan, saya akan membiarkannyas saja dan meminta salah seorang bawahan saya untuk mengerjakan tugas tersebut							;Adalah ide penting bagi saya untuk memperoleh penghargaan atas ide-ide saya yang baik							\r\n', 'A;B'),
(23, 8, 23, 'Saya merasa bawahan-bawahan saya tidak perlu mengerti mengapa mereka mengerjakan sesuatu hal sejauh mereka mengerjakan hal tersebut							\r\n;Saya merasa bahwa jem pencatat waktu datang dan pulangnya para pegawai akan mengurangi keterlambatan							\r\n', 'A;B'),
(24, 8, 24, 'Saya biasanya membuat keputusan-keputusan sendiri dan menyampaikannya kepada bawahan saya							\r\n;Saya merasa bahwa serikat-serikat buruh dan pimpinan perusahaan dapat bekerjasama untuk mencapai tujuan-tujuan bersama							\r\n', 'A;B'),
(25, 8, 25, 'Saya menyukai penggunaan skala penggajian karyawan							\r\n;Saya selalu melakukan diskusi-diskusi untuk mencapai kata sepakat							\r\n', 'A;B'),
(26, 8, 26, 'Saya tidak akan memberikan tugas yang tidak saya senangi kepada orang lain							\r\n;Bila beberapa bawahan saya merasa tidak berbahagia, saya akan mencoba melakukan sesuatu untuk mengatasi hal tersebut							\r\n', 'A;B'),
(27, 8, 27, 'Bila ada tugas yang mendesak, walaupun semua peralatannya sudah disediakan, saya akan membiarkannyas saja dan meminta salah seorang bawahan saya untuk mengerjakan tugas tersebut							;Adalah ide penting bagi saya untuk memperoleh penghargaan atas ide-ide saya yang baik							\r\n', 'A;B'),
(28, 8, 28, 'Tujuan saya adalah berusaha mengerjakan tugas sebaik mungkin tanpa mengeluh							\r\n;Saya memberikan tugas kepada bawahan saya tanpa banyak mempertimbangkan pengalaman atau kemampuan saya lebih menuntut pencapaian hasilnya saja							\r\n', 'A;B'),
(29, 8, 29, 'Saya memberikan tugas kepada bawahan saya tanpa banyak mempertimbangkan pengalaman atau kemampuan. Saya lebih menuntut pencapaian hasilnya saja							\r\n;Saya dengan sabar mendengarkan keluhan-keluhan dan ketidakpuasan-ketidakpuasan bawahan saya, tetapi seringkali saya meralat apa yang mereka katakan							\r\n', 'A;B'),
(30, 8, 30, 'Saya merasa bahwa keluhan-keluhan tidak dapat dicegah dan saya berusaha untuk menghilangkan keluhan tersebut							\r\n;Saya percaya bahwa bawahan-bawahan saya akan merasakan kepuasan kerja tanpa merasa tertekan oleh saya							\r\n', 'A;B'),
(31, 8, 31, 'Bila menghadapi masalah yang sulit, saya berusaha untuk mencapai pemecahan yang dapat diteruma oleh sebagian besar orang							\r\n;Saya percaya bahwa pengalaman bekerja lebih bermanfaat daripada pendidikan teoritis							\r\n', 'A;B'),
(32, 8, 32, 'Saya selalu memberikan tugas-tugas yang sangat sulit kepada karyawan-karyawan yang paling berpengalaman							\r\n;Saya percaya bahwa kenaikan jawabatan adalah semata-mata berdasarkan kemampuan yang ada							\r\n', 'A;B'),
(33, 8, 33, 'Saya merasa bahwa masalah-masalah yang timbul di antara para karyawan biasanya akan dapat diselesaikan di antara mereka sendiri, tanpa campur tangan dari saya							\r\n;Bila saya ditegur oleh atasan saya, saya akan memanggil semua bawahan saya dan mengatakan semua teguran tersebut kepada mereka							\r\n', 'A;B'),
(34, 8, 34, 'Saya tidak peduli dengan apa yang dikerjakan oleh karyawan saya di luar jam kerja kantornya							\r\n;Saya percaya bahwa bawahan-bawahan yang tidak disiplin tidak akan memperbaiki jumlah atau mutu kerja mereka dalam jangka waktu yang panjang							\r\n', 'A;B'),
(35, 8, 35, 'Saya memberikan informasi kepada pimpinan perusahaan yang tidak lebih dari apa yang mereka tanyakan							\r\n;Kadang-kadang saya merasa bahwa apa yang dikeluhkan oleh serikat buruh bukanlah masalah yang mendasar							\r\n', 'A;B'),
(36, 8, 36, 'Saya kadang ragu-ragu untuk membuat suatu keputusan yang akan tidak disukain oleh bawahan-bawahan saya							\r\n;Tujuan saya adalah berusaha mengerjakan tugas sebaik mungkin tanpa mengeluh							\r\n', 'A;B'),
(37, 8, 37, 'Saya dengan sabar mendengarkan keluhan-keluhan dan ketidakpuasan-ketidakpuasan dari bawahan saya, tetapi seringkali saya meralat apa yang mereka katakan							\r\n;Saya kadang ragu-ragu untuk membuat suatu keputusan yang akan tidak disukai oleh bawahan-bawahan saya							\r\n', 'A;B'),
(38, 8, 38, 'Saya mengemukakan pendapat-pendapat saya dimuka umum hanya bila saya merasa bahwa orang lain akan setuju dengan saya							\r\n;Sebagian besar dari bawahan-bawahan saya dapat menyelesaikan tugas-tugas mereka, bila perlu tanpa kehadiran saya							\r\n', 'A;B'),
(39, 8, 39, 'Saya berusaha bekerja sebaik mungkin dan memberikan ide-ide pengembangan pada pimpinan perusahaan							\r\n;Bila saya memberika ntugas kepada bawahan-bawahan saya, saya menentukan batas waktu penyelesaiannya							\r\n', 'A;B'),
(40, 8, 40, 'Saya selalu menganjurkan kepada bawahan saya untuk memberikan usul-usul, tetapi kadang-kadang saya langsung mengambil tindakan tertentu							\r\n;Saya mencoba membuat bawahan-bawahan saya merasa senang apabil mereka beerbicara dengan saya							\r\n', 'A;B'),
(41, 8, 41, 'Di dalam diskusi-diskusi saya memberikan fakta-fakta sesuai pemahaman bawahan saya, dan membiarkan mereka untuk membuat kesimpulan sendiri							\r\n;Bila direktur memberikan perintah yang kurang menyenangkan, saya pikir adalah cukup bijaksana bila saya menyebutkan namanya dan bukan nama saya							\r\n', 'A;B'),
(42, 8, 42, 'Bila ada tugas-tugas mendadak atau tugas yang tidak menyenangkan, sebelumnya saya akan meminta beberapa sukarelawan yang mau mengerjakan tugas tersebut							\r\n;Saya menunjukkan minat saya terhadap kehidupan pribadi bawahan-bawahan saya, karena sayapun mengharapkan mereka berbuat seperti itu kepada saya							\r\n', 'A;B'),
(43, 8, 43, 'Saya selalu memperhatikan kebahagiaan karyawan-karyawan saya saat mereka mengerjakan tugas-tugas mereka							\r\n;Saya selalu memperhatikan keterlambatan dan kemangkiran bawahan saya							\r\n', 'A;B'),
(44, 8, 44, 'Sebagian besar dari bawahan-bawahan saya dapat menyelesaikan tugas-tugas mereka, bila perlu, tanpa kehadiran saya							\r\n;Bila ada sesuatu tugas yang mendesak, walaupun semua peralatannya sudah disediakan, saya akan membiarkannya saja dan meminta salah seorang bawahan saya untuk mengerjakan tugas tersebut							\r\n', 'A;B'),
(46, 8, 46, 'Saya percaya bahwa pertemuan-pertemuan yang sering dengan karyawan secara pribadi akan membantu pengembangan diri mereka							\r\n;Saya selalu memperhatikan kebahagiaan karyawan-karyawan saya saat mereka mengerjakan tugas-tugas mereka							\r\n', 'A;B'),
(47, 8, 47, 'Saya mendukung bawahan saya yang ingin meningkatkan pengetahuan tentang pekerjaan dan perusahaan, walaupun hal itu sebenarnya belum diperlukan untuk kedudukan mereka sekarang							\r\n;Saya mengawasi benar bawahan-bawahan saya yang kurang mahir dalam pekerjaannya atau bawahan-bawahan saya yang hasil kerjanya kurang memuaskan							\r\n', 'A;B'),
(48, 8, 48, 'Saya mengijinkan bawahan-bawahan saya untuk ikut serta dalam pengambilan keputusan dan saya selalu mematuhi keputusan yang dibuat berdasarkan suara terbanyak							\r\n;Saya membuat bawahan-bawahan saya bekerja keras, dan saya berusaha meyakinkan mereka bahwa biasanya mereka akan mendapat perlakukan yang adil dari pimpinan perusahaan							\r\n', 'A;B'),
(49, 8, 49, 'Saya merasa bahwa semua gaji karyawan pada jabatan yang sama seharusnya memperoleh gaji yang sama							\r\n;Bila ada seorang karyawan yang hasil kerjanya selalu tidak memuaskan saya, saya akan menunggu suatu kesempatan untuk memindahkannya dan bukan untuk memecatnya							\r\n', 'A;B'),
(50, 8, 50, 'Saya merasa bahwa tujuan-tujuan serikat buruh dan tujuan-tujuan perusahaan saling berbeda							\r\n;Saya merasa bahwa dengan bekerja keras bagi bawahan saya, mereka akan menyenangi saya							\r\n', 'A;B'),
(51, 8, 51, 'Saya mengawasi benar bawahan-bawahan saya yang kurang mahir dalam pekerjaannya atau bawahan-bawahan saya yang hasil kerjanya kurang memuaskan							\r\n;Saya mencela pembicaraan-pembicaraan yang tidak perlu di antara bawahan-bawahan saya, selama mereka bekerja							\r\n', 'A;B'),
(52, 8, 52, 'Bila saya memberikan tugas kepada bawahan-bawahan saya, saya menentuka batas waktu penyelesaiannya							\r\n;Saya tidak akan memberikan tugas yang tidak saya senangi kepada orang lain							\r\n', 'A;B'),
(53, 8, 53, 'Saya percaya bahwa pengalaman bekerja lebih bermanfaat daripada pendidikan teoritis							\r\n;Saya tidak peduli dengan apa yang dikerjakan oleh para pegawai saya di luar jam kantornya							\r\n', 'A;B'),
(54, 8, 54, 'Saya merasa bahwa jam pencatat waktu datang dan pulangnya para pegawai akan mengurangi keterlambatan							\r\n;Saya mengijinkan bawahan-bawahan saya uyntuk ikut serta dalam pengambilan keputusan dan saya selalu mematuhi keputusan yang dibuat berdasarkan suara terbanyak							\r\n', 'A;B'),
(55, 8, 55, 'Saya membuat keputusan-keputusan sendiri, tetapi saya dapat mempertimbangkan saran-saran yang wajar dari bawahan-bawahan saya							\r\n;Saya merasa bahwa tujuan-tujuan serikat buruh dan tujuan-tujuan perusahaan adalah saling berbeda							\r\n', 'A;B'),
(57, 8, 57, 'Saya tidak akan ragu-ragu untuk mempekerjakan pegawai-pegawai yang cacat jasmani, bilamana saya merasa pasti bahwa mereka dapat menangani pekerjaannya							\r\n;Saya tidak akan menegur pelanggaran-pelanggar peraturan, bila saya merasa pasti bahwa tidak ada satu orangpun yang mengetahui tentang pelanggaran-pelanggaran tersebut							\r\n', 'A;B'),
(58, 8, 58, 'Apabila mungkin, saya akan membentuk kelompok-kelompok kerja yang terdiri dari orang-orang yang sudah menjadi teman-teman baik saya							\r\n;Saya akan memebrikan tugas-tugas yang sulit kepada bawahan-bawahan saya yang belum berpengalaman, tetapi bila mereka memperoleh kesukaran, saya akan mengambil alih tanggung jawab mereka							\r\n', 'A;B'),
(59, 8, 59, 'Saya membuat bawahan-bawahan saya bekerja keras, dan saya berusaha meyakinkan mereka bahwa biasanya mereka akan mendapat perlakukan yang adil dari pimpinan perusahaan							\r\n;Saya percaya bahwa penerapan disiplin adalah merupakan contoh untuk karyawan-karyawan lainnya							\r\n', 'A;B'),
(60, 8, 60, 'Saya mencoba untuk membuat bawahan-bawahan saya merasa senang apabila mereka berbicara dengan saya							\r\n;Saya menyukai penggunaan skala penggajian karyawan							\r\n', 'A;B'),
(61, 8, 61, 'Saya percaya bahwa kenaikan jabatan dalah semata-mata berdasarkan kemampuan yang ada							\r\n;Saya merasa bahwa masalah-masalah yang timbul di antara para karyawan biasanya akan dapat diselesaikan di antara mereka sendiri, tanpa campur tangan dari saya							\r\n', 'A;B'),
(62, 8, 62, 'Saya merasa bahwa serikat-serikat buruh dan pimpinan perusahaan bekerja untuk mencapai tujuan-tujuan yang sama						;Di dalam diskusi, saya memberikan fakta-fakta sesuai pemahaman bawahan saya, dan membiarkan mereka untuk membuat kesimpulan sendiri							', 'A;B'),
(63, 8, 63, 'Bila seorang karyawan tidak sanggup menyelesaikan tugasnya, saya akan membantu dia untuk menyelesaikan tugas tersebut							\r\n;Saya merasa bahwa semua karyawan pada jabatan yang sama seharusnya memperoleh gaji yang sama							\r\n', 'A;B'),
(64, 8, 64, 'Saya mengijinkan bawahan-bawhaabn saya untuk ikut serta dalam pengambilan keputusan, tetapi saya pun menyediakan sesuatu yang jitu sebagai keputusan terakhir							\r\n;Saya tidak akan ragu-ragu untuk mempekerjakan pegawai-pegawai yang cacat jasmaninya, bilamana saya merasa bahwa mereka dapat menangani pekerjaanya							\r\n', 'A;B'),
(69, 8, 45, 'Saya percaya bahaw bawahan-bawahan saya akan merasakan kepuasan kerja tanpa merasa tertekan oleh saya							\r\n;Saya memberikan informasi kepada \'dewan pimpinan perusahaan\' tidak lebih dari apa yang mereka tanyakan							\r\n', 'A;B'),
(70, 8, 56, 'Saya membuat keputusan-keputusan sendiri dan kemudian saya mencoba untuk \'menjual\' keputusan-keputusan itu kepada bawahan saya							\r\n;Apabila mungkin, saya akan membentuk kelompok-kelompok kerja yang terdiri dari orang-orang yang sudah menjadi teman baik saya							\r\n', 'A;B'),
(71, 8, 7, 'Bila jumlah dan mutu hasil kerja bagian saya tidak memuaskan, saya mengatakan pada bawahan-bawahan saya bahwa direktur merasa kecewa. Oleh karena itu mereka harus memperbaiki kerja mereka							;Saya membuat keputusan-keputusan sendiri dan kemudian saya mencoba untuk \'menjual\' keputusan-keputusan itu kepada bawahan saya', 'A;B');

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul_8`
--

CREATE TABLE `modul_8` (
  `id` int(11) NOT NULL,
  `soal_id` int(11) NOT NULL,
  `nomor_soal` int(11) NOT NULL,
  `pernyataan` text NOT NULL,
  `kategori` enum('favorable','unfavorable','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `modul_8`
--

INSERT INTO `modul_8` (`id`, `soal_id`, `nomor_soal`, `pernyataan`, `kategori`) VALUES
(1, 10, 1, 'Saya bersedia menyesuaikan kebutuhan pribadi demi kebutuhan perusahaan', 'favorable'),
(2, 10, 2, 'Saya akan meluangkan waktu ekstra untuk membantu pekerjaan rekan saya', 'favorable'),
(3, 10, 3, 'Saya tidak peduli pada kesalahan yang dilakukan orang lain selama saya tidak terlibat', 'unfavorable'),
(4, 10, 4, 'Saya sering menciptakan solusi permasalahan yang lebih efektif', 'favorable'),
(5, 10, 5, 'Saya senang menegur kesalahan orang lain', 'favorable'),
(6, 10, 6, 'Saya perfectionis dalam bekerja', 'favorable'),
(7, 10, 7, 'Saya tetap berprinsip idealis meskipun ada instruksi dari atasan', 'favorable'),
(8, 10, 8, 'Saya bersedia bekerja lembur tanpa diminta', 'favorable'),
(9, 10, 9, 'Tidak semua aturan harus dipatuhi', 'unfavorable'),
(10, 10, 10, 'Saya akan menegur siapa saja yang melanggar aturan, meskipun itu pimpinan ', 'favorable'),
(11, 10, 11, 'Saya senang terlibat dan antusias dalam mewujudkan ide-ide yang inovatif ', 'favorable'),
(12, 10, 12, 'Saya bersikap agak cuek', 'unfavorable'),
(13, 10, 13, 'Saya tidak senang dengan perubahan', 'unfavorable'),
(14, 10, 14, 'Saya perhatian terhadap tata tertib dan kebersihan lingkungan', 'favorable'),
(15, 10, 15, 'Saya tidak senang mengikuti perubahan zaman', 'unfavorable'),
(16, 10, 16, 'Kebutuhan pribadi dan keluarga adalah hal yang tidak bisa ditawar', 'unfavorable'),
(17, 10, 17, 'Saya tidak akan mengubah pendapat saya meskipun membahayakan posisi saya dalam organisasi', 'favorable'),
(18, 10, 18, 'Saya siap menyakiti perasaan orang lain selama itu benar', 'favorable'),
(19, 10, 19, 'Saya mengembangkan standar kualitas kerja yang ada dilingkungan saya', 'favorable'),
(20, 10, 20, 'Saya merasa terkekang dengan aturan', 'unfavorable'),
(21, 10, 21, 'Saya sering tidak tega terhadap orang lain', 'unfavorable'),
(22, 10, 22, 'Menegur itu adalah tugas atasan', 'unfavorable'),
(23, 10, 23, 'Bekerja lembur tanpa dibayar adalah hal yang tidak adil', 'unfavorable'),
(24, 10, 24, 'Pekerjaan tambahan hanya memberikan keuntungan perusahaan dan tidak untuk karyawan', 'unfavorable'),
(25, 10, 25, 'Terlalu banyak peraturan membuat bosan', 'unfavorable'),
(26, 10, 26, 'Saya tidak suka diribetkan dengan hal-hal detail', 'unfavorable'),
(27, 10, 27, 'Saya bersedia meluangkan waktu pribadi untuk membantu tim', 'favorable'),
(28, 10, 28, 'Diluar jam kerja, saya tidak senang di ganggu', 'unfavorable'),
(29, 10, 29, 'Perfectionis itu tidak baik', 'unfavorable'),
(30, 10, 30, 'Saya hanya bertanggung jawab atas apa yang saya kerjakan', 'unfavorable'),
(31, 10, 31, 'Komunikasi kerja cukup hanya di tempat kerja', 'unfavorable'),
(32, 10, 32, 'Saya berkomitmen bahwa hidup saya harus selalu berubah dan berkembang', 'favorable'),
(33, 10, 33, 'Saya sering mengingatkan dan menegur orang lain untuk perhatian terhadap sekitar', 'favorable'),
(34, 10, 34, 'Lebih baik dengan yang ada saat ini dari pada mencari hal yang baru', 'unfavorable'),
(35, 10, 35, 'Saya lebih mudah bekerja sendiri', 'unfavorable'),
(36, 10, 36, 'Capaian dan kepentingan tim saya di atas segalanya', 'favorable'),
(37, 10, 37, 'Kelalaian itu manusiawi ', 'unfavorable');

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul_9`
--

CREATE TABLE `modul_9` (
  `id` int(11) NOT NULL,
  `soal_id` int(11) NOT NULL,
  `nomor_soal` int(11) NOT NULL,
  `pernyataan` text NOT NULL,
  `kategori` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `modul_9`
--

INSERT INTO `modul_9` (`id`, `soal_id`, `nomor_soal`, `pernyataan`, `kategori`) VALUES
(2, 9, 1, 'Saya suka bekerja dengan hal yang berkaitan dengan otomotif\r\n', 'R'),
(3, 9, 2, 'Saya suka mengerjakan puzzle', 'I'),
(4, 9, 3, 'Saya dapat bekerja secara mandiri/independen\r\n', 'A'),
(5, 9, 4, 'Saya suka bekerja dalam tim\r\n', 'S'),
(6, 9, 5, 'Saya orang yang memiliki ambisi dan tujuan untuk diri sendiri\r\n', 'E'),
(7, 9, 6, 'Saya suka mengatur sesuatu (dokumen, pekerjaan kantor, dll)\r\n', 'C'),
(8, 9, 7, 'Saya suka membuat barang/benda\r\n', 'R'),
(9, 9, 8, 'Saya suka membaca hal yang berkaitan tentang seni dan musik\r\n', 'A'),
(10, 9, 9, 'Saya suka mengikuti instruksi yang jelas\r\n', 'C'),
(11, 9, 10, 'Saya suka mempengaruhi dan meyakinkan orang lain\r\n', 'E'),
(12, 9, 11, 'Saya suka melakukan eksperimen\r\n', 'I'),
(13, 9, 12, 'Saya suka mengajari atau melatih orang lain\r\n', 'S'),
(14, 9, 13, 'Saya suka membantu orang lain dalam memecahkan masalahnya\r\n', 'S'),
(15, 9, 14, 'Saya senang memelihara binatang\r\n', 'R'),
(16, 9, 15, 'Saya bersedia bekerja 8 jam per hari di kantor\r\n', 'C'),
(17, 9, 16, 'Saya suka berjualan\r\n', 'S'),
(18, 9, 17, 'Saya menikmati bacaan yang kreatif\r\n', 'A'),
(19, 9, 18, 'Saya menikmati hal-hal yang berkaitan dengan ilmu pengetahuan\r\n', 'I'),
(20, 9, 19, 'Saya mampu mengambil tanggung jawab baru dengan cepat\r\n', 'E'),
(21, 9, 20, 'Saya tertarik untuk merawat orang lain\r\n', 'S'),
(22, 9, 21, 'Saya suka mencari tahu tentang proses suatu hal terjadi\r\n', 'I'),
(23, 9, 22, 'Saya suka meletakkan segala sesuatu bersama-sama atau atau merakit sesuatu\r\n', 'R'),
(24, 9, 23, 'Saya orang yang kreatif\r\n', 'A'),
(25, 9, 24, 'Saya memperhatikan hal-hal detil\r\n', 'C'),
(26, 9, 25, 'Saya suka mengarsipkan berkas\r\n', 'C'),
(27, 9, 26, 'Saya suka menganalisa suatu masalah atau situasi\r\n', 'I'),
(28, 9, 27, 'Saya suka menyanyi atau memainkan instrumen\r\n', 'A'),
(29, 9, 28, 'Saya menikmati belajar budaya lain\r\n', 'S'),
(30, 9, 29, 'Saya ingin memulai usaha/bisnis saya sendiri\r\n', 'E'),
(31, 9, 30, 'Saya suka memasak\r\n', 'R'),
(32, 9, 31, 'Saya senang bermain peran\r\n', 'A'),
(33, 9, 32, 'Saya adalah orang yang praktis\r\n', 'R'),
(34, 9, 33, 'Saya senang bekerja dengan angka atau grafik\r\n', 'I'),
(35, 9, 34, 'Saya suka berdiskusi tentang isu-isu tertentu\r\n', 'S'),
(36, 9, 35, 'Saya bisa menjaga data pekerjaan saya\r\n', 'C'),
(37, 9, 36, 'Saya suka memimpin\r\n', 'E'),
(38, 9, 37, 'Saya suka bekerja di luar ruangan\r\n', 'R'),
(39, 9, 38, 'saya suka bekerja di dalam kantor\r\n', 'C'),
(40, 9, 39, 'saya pandai matematika\r\n', 'I'),
(41, 9, 40, 'Saya suka membantu orang lain\r\n', 'S'),
(42, 9, 41, 'saya suka menggambar\r\n', 'A'),
(43, 9, 42, 'Saya senang berpidato\r\n', 'E');

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul_10_an`
--

CREATE TABLE `modul_10_an` (
  `id` int(11) NOT NULL,
  `soal_id` int(11) NOT NULL,
  `nomor_soal` int(11) NOT NULL,
  `teks_soal` text NOT NULL,
  `pilihan` text NOT NULL,
  `kunci_jawaban` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `modul_10_an`
--

INSERT INTO `modul_10_an` (`id`, `soal_id`, `nomor_soal`, `teks_soal`, `pilihan`, `kunci_jawaban`) VALUES
(1, 16, 41, 'menemukan : menghilang = mengingat : ?', 'menghapal;mengenal;melupakan;berpikir;memimpikan;', 'c'),
(2, 16, 42, 'bunga : jambangan = burung : ?', 'sarang;langit;pagar;pohon;sangkar;', 'e'),
(3, 16, 43, 'kereta api : rel = bis : ?', 'roda;poros;ban;jalan raya;kecepatan;', 'd'),
(4, 16, 44, 'perak : emas = cincin : ?', 'arloji;berlian;permata;gelang;platina;', 'd'),
(5, 16, 45, 'lingkaran : bola = bujur sangkar : ?', 'bentuk;gambar;segi empat;kubus;piramida;', 'd'),
(6, 16, 46, 'saran : keputusan = merundingkan : ?', 'menawarkan;menentukan;menilai;menimbang;merenungkan;', 'b'),
(7, 16, 47, 'lidah : asam = hidung : ?', 'mencium;bernapas;mengecap;tengik;asin;', 'd'),
(8, 16, 48, 'darah : pembuluh= air : ?', 'pintu air;air sungai;talang;hujan;ember;', 'b'),
(9, 16, 49, 'saraf : penyalur = pupil : ?', 'penyinaran;mata;melihat;cahaya;pelindung;', 'e'),
(10, 16, 50, 'pengantar surat : pengantar telegram = pandai besi : ?', 'palu godam;pedagang besi;api;tukang emas;besi tempa;', 'd'),
(11, 16, 51, 'buta : warna = tuli : ?', 'pendengaran;mendengar;nada;kata;telinga;', 'c'),
(12, 16, 52, 'makanan : bumbu = ceramah : ?', 'penghinaan;pidato;kelakar;kesan;ayat;', 'c'),
(13, 16, 53, 'marah : emosi = duka cita : ?', 'suka cita;sakit hati;suasana hati;sedih;rindu;', 'c'),
(14, 16, 54, 'mantel : jubah = wol : ?	', 'bahan sandang;domba;sutera;jas;tekstil;', 'c'),
(15, 16, 55, 'ketinggian puncak : tekanan udara = ketinggian nada : ?				', 'garpu penala;sopran;nyanyian;panjang senar;suara;', 'd'),
(16, 16, 56, 'negara : revolusi = hidup : ?', 'biologi;keturunan;mutasi;seleksi;ilmu hewan;', 'c'),
(17, 16, 57, 'kekurangan : penemuan = panas : ?', 'haus;khatulistiwa;es;matahari;dingin;', 'c'),
(18, 16, 58, 'kayu : diketam = besi : ?', 'dipalu;digergaji;dituang;dikikir;ditempa;', 'd'),
(19, 16, 59, 'olahragawan : lembing = cendikiawan : ?', 'perpustakaan;penelitian;karya;studi;mikroskop;', 'e'),
(20, 16, 60, 'keledai : kuda pacuan = pembakaran : ?', 'pemadam api;obor;letupan;korek api;lautan api;', 'e');

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul_10_fa`
--

CREATE TABLE `modul_10_fa` (
  `id` int(11) NOT NULL,
  `soal_id` int(11) NOT NULL,
  `nomor_soal` int(11) NOT NULL,
  `link_gambar` text NOT NULL,
  `kunci_jawaban` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `modul_10_fa`
--

INSERT INTO `modul_10_fa` (`id`, `soal_id`, `nomor_soal`, `link_gambar`, `kunci_jawaban`) VALUES
(1, 20, 1, '1_20_1.png', 'a'),
(2, 20, 2, '2_20_2.png', 'c'),
(3, 20, 3, '3_20_3.png', 'b'),
(4, 20, 4, '4_20_4.png', 'a'),
(5, 20, 5, '5_20_5.png', 'd'),
(6, 20, 6, '6_20_6.png', 'b'),
(7, 20, 7, '7_20_7.png', 'c'),
(8, 20, 8, '8_20_8.png', 'e'),
(9, 20, 9, '9_20_9.png', 'e'),
(10, 20, 10, '10_20_10.png', 'd'),
(11, 20, 11, '11_20_11.png', 'e'),
(12, 20, 12, '12_20_12.png', 'b'),
(13, 20, 13, '13_20_13.png', 'd'),
(14, 20, 14, '14_20_14.png', 'c'),
(15, 20, 15, '15_20_15.png', 'b'),
(16, 20, 16, '16_20_16.png', 'a');

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul_10_ge`
--

CREATE TABLE `modul_10_ge` (
  `id` int(11) NOT NULL,
  `soal_id` int(11) NOT NULL,
  `nomor_soal` int(11) NOT NULL,
  `teks_soal` text NOT NULL,
  `nilai_2` text NOT NULL,
  `nilai_1` text NOT NULL,
  `nilai_0` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `modul_10_ge`
--

INSERT INTO `modul_10_ge` (`id`, `soal_id`, `nomor_soal`, `teks_soal`, `nilai_2`, `nilai_1`, `nilai_0`) VALUES
(1, 19, 1, 'Mawar - Melati', 'bunga;kembang;perdu;', 'tumbuh-tumbuhan;tangkai;harum;', 'pohon;'),
(2, 19, 2, 'Mata - telinga', 'alat indera;indera;panca indera;', 'organ;alat tubuh;', 'kepala;alat;'),
(3, 19, 3, 'Gula - intan', 'kidung;kristal;zat arang;', 'berkilauan;mengkilat;bening;', 'mahal;permata;'),
(4, 19, 4, 'Hujan - salju', 'cuaca;', 'air;basah;gejala alam;', 'musim dingin;iklim;'),
(5, 19, 5, 'Pengantar surat - telepon', 'pembawa berita;alat perhubungan;', 'pos;telekomunikasi;perhubungan;komunikasi;', ';'),
(6, 19, 6, 'Kamera - kacamata', 'alat optik;optik;', 'lensa;', 'melihat;alat penglihatan;alat;'),
(7, 19, 7, 'Lambung - usus', 'alat pencernaan;', 'jalan makanan;perut;isiperut;pencernaan makanan;', 'makanan;'),
(8, 19, 8, 'Banyak - sedikit', 'penyebut jumlah;pengertian jumlah;jumlah;kuantitas;', 'mengukur;ukuran;', 'uang;'),
(9, 19, 9, 'Telur - benih', 'bibit;bakal;alat pembiakan;permulaan;penghidupan;', 'sel;pembiakan;', 'pertanian;'),
(10, 19, 10, 'Bendera - lencana', 'simbol;lambang;tanda;', 'nama;tanda pengenal;', 'warna;'),
(11, 19, 11, 'Rumput - gajah', 'makhluk;makhluk hidup;organisme;', 'tumbuh-tumbuhan;biologi;ilmu hayat;', 'hidup;hayat;hutan;'),
(12, 19, 12, 'Ember - kantong', 'wadah;tempat pengisi;tempat menyimpan;', 'alat;tempat sesuatu;tempat;benda;', 'lobang;'),
(13, 19, 13, 'Awal - akhir', 'pengertian waktu;batas;', 'waktu;masa;saat;lamanya;', 'kata waktu;buku;'),
(14, 19, 14, 'Kikir - Boros', 'sifat - watak;sifat - karakter;', 'sifat;', 'uang;watak;karakter;'),
(15, 19, 15, 'Penawaran - permintaan', 'regulator harga;pengertian ekonomi;', 'dagang;niaga;penjualan;pembelian;jual beli;', 'lawan kata;'),
(16, 19, 16, 'Atas - bawah', 'pengertian ruang;penyebut ruang;', 'arah;letak;posisi;penentuan daerah;tempat;ruang;penunjuk tempat;', 'daerah;tingkatan;ruangan;kata;');

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul_10_ra`
--

CREATE TABLE `modul_10_ra` (
  `id` int(11) NOT NULL,
  `soal_id` int(11) NOT NULL,
  `nomor_soal` int(11) NOT NULL,
  `teks_soal` text NOT NULL,
  `pilihan` text NOT NULL,
  `kunci_jawaban` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `modul_10_ra`
--

INSERT INTO `modul_10_ra` (`id`, `soal_id`, `nomor_soal`, `teks_soal`, `pilihan`, `kunci_jawaban`) VALUES
(1, 17, 61, 'Jika seorang anak memiliki 50 rupiah dan memberikan 15 rupiah, berapa rupiahkan yang masih tersisa padanya?', '23;35;30;36;37', 'b'),
(2, 17, 62, 'Berapa km-kah yang dapat ditempuh oleh kereta api dalam waktu 7 jam jika kecepatannya 40 km/jam?', '230;305;280;180;208;', 'c'),
(3, 17, 63, '15 peti buah-buahan beratnya 250 kg dan setiap peti kosong beratnya 3 kg, berapakah berat buah-buahan itu?', '250;260;205;275;255;', 'a'),
(4, 17, 64, 'Seseorang mempunyai persediaan rumput yang cukup untuk 7 ekor kuda selama 78 hari. Berapa harikah persediaan itu cukup untuk 21 ekor kuda?', '24;34;16;26;36;', 'd'),
(5, 17, 65, '3 batang coklat harganya 5 rupiah, berapa batangkah yang dapat kita beli dengan uang 50 rupiah?', '30;32;30;26;46;', 'a'),
(6, 17, 66, 'Seseorang dapat berjalan 1,76 m dalam waktu 1/4 detik. Berapa meterkan yang dapat ia tempuh dalam waktu 10 detik?', '60;72;70;56;76;', 'c'),
(7, 17, 67, 'Jika sebuah batu terletak 15 km di sebelah selatan dari sebatang pohon dan pohon itu berada 30 m di sebelah selatan dari sebuah rumah, berapa meterkan jarak antara batu dan rumah itu?	', '54;45;64;46;44;', 'b'),
(8, 17, 68, 'Jika 4 1/4 m bahan sandang harganya 90 rupiah, berapa rupiakah harganya 2 1/2 m?', '84;30;40;50;60;', 'd'),
(9, 17, 69, '7 orang dapat menyelesaikan sesuatu pekerjaan dalam waktu 6 hari. Berapa orangkah yang diperlukan untuk menyelesaikan pekerjaan itu dalam setengah hari?', '84;48;34;44;24;', 'b'),
(10, 17, 70, 'Karena dipanaskan, kawat yang panjangnya 48 cm akan mengembang menjadi 52 cm. Setelah pemanasan, berapakah panjangnya kawat yang berukuran 72 cm?', '66;68;67;76;56;', 'c'),
(11, 17, 71, 'Suatu pabrik dapat menghasilkan 304 batang pensil dalam waktu 8 jam. Berapa batangkah dihasilkan dalam waktu setengah jam?', '17;19;18;16;15;', 'b'),
(12, 17, 72, 'Untuk suatu campuran diperlukan 2 bagian perak dan 3 bagian timah. Berapa gram perak yang diperlukan untuk mendapatkan campuran itu yang beratnya 15 gram?', '17;8;19;6;5;', 'd'),
(13, 17, 74, 'Mesin A menenun 60 m kain, sedangkan mesin B menenun 40 m. Berapa meterkah yang ditenun mesin A, jika mesin B menenun 60 m?', '98;76;90;84;62;', 'c'),
(14, 17, 79, 'Jika suatu botol berisi anggur hanya 7/8 bagian dan harganya ialah 84 rupiah, berapa harga anggur itu jika botol itu hanya terisi 1/2 penuh?', '44;46;48;36;54;', 'c'),
(15, 17, 80, 'Di dalam satu keluarga, setiap anak perempuan mempunyai jumlah saudara laki-laki yang sama dengan jumlah saudara perempuan dan setiap anak laki-laki mempunyai dua kali lebih banyak saudara perempuan daripada saudara laki-laki. Berapa anak laki-lakikah yang terdapat dalam keluarga itu?', '2;5;3;1;4;', 'c');

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul_10_se`
--

CREATE TABLE `modul_10_se` (
  `id` int(11) NOT NULL,
  `soal_id` int(11) NOT NULL,
  `nomor_soal` int(11) NOT NULL,
  `teks_soal` text NOT NULL,
  `pilihan` text NOT NULL,
  `kunci_jawaban` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `modul_10_se`
--

INSERT INTO `modul_10_se` (`id`, `soal_id`, `nomor_soal`, `teks_soal`, `pilihan`, `kunci_jawaban`) VALUES
(1, 11, 1, 'Pengaruh seseorang terhadap orang lain seharusnya bergantung pada…........', 'kekuasaan;bujukan;kekayaan;keberanian;kewibawaa', 'e'),
(3, 11, 2, 'Lawannya &quot;hemat&quot; adalah….......', 'murah;kikir;boros;bernilai;kaya;', 'c'),
(4, 11, 3, '…............ tidak termasuk cuaca', 'angin puyuh;halilintar;salju;gempa bumi;kabut;', 'd'),
(5, 11, 4, 'Lawannya &quot;setia&quot; adalah…................			', 'cinta;benci;persahabatan;khianat;permusuhan;', 'd'),
(6, 11, 5, 'Seekor kuda selalu mempunyai…............', 'kandang;ladam;pelana;kuku;surai;', 'd'),
(7, 11, 6, 'Seorang paman …............ lebih tua dari pada kemenakannya', 'jarang;biasanya;selalu;tak pernah;kadang-kadang;', 'c'),
(8, 11, 7, 'Pada jumlah yang sama, nilai kalori yang tertinggi terdapat pada…............', 'ikan;daging;lemak;tahu;sayuran;', 'b'),
(9, 11, 8, 'Pada suatu pertandingan selalu terdapat…..............', 'lawan;wasit;penonton;sorak;kemenangan;', 'a'),
(10, 11, 9, 'Suatu pernyataan yang belum dipastikan dikatakan sebagai pernyataan yang …...............', 'paradoks;tergesa-gesa;mempunyai arti rangkap;menyesatkan;hipotesis;', 'e'),
(11, 11, 10, 'Pada sepatu selalu terdapat …............', 'kulit;sol;tali sepatu;gesper;lidah;', 'b'),
(12, 11, 11, 'Suatu ….............. tidak menyangkut persoalan pencegahan kecelakaan.', 'lampu lalu lintas;kacamata pelindung;kotak PPPK;tanda peringatan;palang kereta api;', 'c'),
(13, 11, 12, 'Mata uang adari Rp. 500 garis tengahnya adalah…...........', '17;29;25;24;15;', 'd'),
(14, 11, 13, 'Seorang yang bersikap menyangsikan setiap kemajuan ialah seorang yang ….............', 'demokratis;radikal;liberal;konservatif;anarkis;', 'd'),
(15, 11, 14, 'Lawannya &quot;tidak pernah&quot; ialah …...............', 'sering;kadang-karang;jarang;kerap kali;selalu;', 'e'),
(16, 11, 15, 'Jarak antara Jakarta - Surabaya adalah kira-kira …............. Km', '650;1000;800;600;950;', 'c'),
(17, 11, 16, 'Untuk membuat nada yang rendah dan mendalam, kita memerlukan banyak …..............', 'kekuatan;peranan;ayunan;berat;suara;', 'e'),
(18, 11, 17, 'Ayah ….............. lebih berpengalaman dari pada anaknya', 'selalu;biasanya;jauh;jarang;pada dasarnya;', 'b'),
(19, 11, 18, 'Di antara kota-kota yang berikut ini, maka kota ….............. letaknya paling selatan', 'Jakarta;Bandung;Cirebon;Semarang;Surabaya;', 'b'),
(20, 11, 19, 'Jika kita dapat mengetahui jumlah presentase nomor-nomor lotre yang tidak menang, maka kita dapat menghitung …......', 'jumlah nomor yang menang;pajak lotre;kemungkinana menang;jumlah pengikut;tinggu keuntungan;', 'c'),
(21, 11, 20, 'Seorang anak yang berumur 10 tahun tingginya rata-rata …......... Cm', '150;130;110;105;114;', 'b');

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul_10_wa`
--

CREATE TABLE `modul_10_wa` (
  `id` int(11) NOT NULL,
  `soal_id` int(11) NOT NULL,
  `nomor_soal` int(11) NOT NULL,
  `pilihan` text NOT NULL,
  `kunci_jawaban` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `modul_10_wa`
--

INSERT INTO `modul_10_wa` (`id`, `soal_id`, `nomor_soal`, `pilihan`, `kunci_jawaban`) VALUES
(1, 15, 21, 'lingkaran;panah;lingkaran;lingkaran;lengkungan;', 'b'),
(2, 15, 22, 'mengetuk;memaki;menjahit;menggergaji;memukul;', 'b'),
(3, 15, 23, 'lebar;keliling;luas;isi;panjang;', 'd'),
(4, 15, 24, 'mengikat;menyatukan;melepaskan;mengaitkan;melekatkan;', 'c'),
(5, 15, 25, 'arah;timur;perjalanan;tujuan;selatan;', 'c'),
(6, 15, 26, 'jarak;perpisahan;tugas;batas;perceraian;', 'c'),
(7, 15, 27, 'saringan;kelambu;payung;tapisan;jala;', 'c'),
(8, 15, 28, 'putih;pucat;buram;kasar;berkilauan;', 'd'),
(9, 15, 29, 'bis;pesawat terbang;sepeda motor;sepeda motor;kapal api;', 'd'),
(10, 15, 30, 'biola;seruling;klarinet;terompet;saxophone;', 'a'),
(11, 15, 31, 'bergelombang;kasar;berduri;licin;lurus;', 'e'),
(12, 15, 32, 'jam;kompas;penunjuk jalan;bintang pari;arah;', 'a'),
(13, 15, 33, 'kebijakan;pendidikan;perencanaan;penempatan;pengerahan;', 'a'),
(14, 15, 34, 'bermotor;berjalan;berlayar;bersepeda;berkuda;', 'b'),
(15, 15, 35, 'gambar;lukisan;potret;patung;ukiran;', 'c'),
(16, 15, 36, 'panjang;lonjong;runcing;bulat;bersudut;', 'a'),
(17, 15, 37, 'kunci;palang pintu;gerendel;gunting;obeng;', 'd'),
(18, 15, 38, 'jembatan;batas;perkawinan;pagar;masyarakat;', 'e'),
(19, 15, 39, 'mengetam;memahat;mengasah;melicinkan;menggosok;', 'b'),
(20, 15, 40, 'batu;baja;bulu;karet;kayu;', 'c');

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul_10_wu`
--

CREATE TABLE `modul_10_wu` (
  `id` int(11) NOT NULL,
  `soal_id` int(11) NOT NULL,
  `nomor_soal` int(11) NOT NULL,
  `link_gambar` text NOT NULL,
  `kunci_jawaban` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `modul_10_wu`
--

INSERT INTO `modul_10_wu` (`id`, `soal_id`, `nomor_soal`, `link_gambar`, `kunci_jawaban`) VALUES
(1, 21, 21, '1_21_21.png', 'a'),
(2, 21, 22, '2_21_22.png', 'c'),
(3, 21, 23, '3_21_23.png', 'd'),
(4, 21, 24, '4_21_24.png', 'e'),
(5, 21, 25, '5_21_25.png', 'a'),
(6, 21, 26, '6_21_26.png', 'c'),
(7, 21, 27, '7_21_27.png', 'd'),
(8, 21, 28, '8_21_28.png', 'c'),
(9, 21, 29, '9_21_29.png', 'e'),
(10, 21, 30, '10_21_30.png', 'a'),
(11, 21, 31, '11_21_31.png', 'b'),
(12, 21, 32, '12_21_32.png', 'd'),
(13, 21, 33, '13_21_33.png', 'e'),
(14, 21, 34, '14_21_34.png', 'b'),
(15, 21, 35, '15_21_35.png', 'd'),
(16, 21, 36, '16_21_36.png', 'b'),
(17, 21, 37, '17_21_37.png', 'a'),
(18, 21, 38, '18_21_38.png', 'e'),
(19, 21, 39, '19_21_39.png', 'b'),
(20, 21, 40, '20_21_40.png', 'c');

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul_10_zr`
--

CREATE TABLE `modul_10_zr` (
  `id` int(11) NOT NULL,
  `soal_id` int(11) NOT NULL,
  `nomor_soal` int(11) NOT NULL,
  `teks_soal` text NOT NULL,
  `pilihan` text NOT NULL,
  `kunci_jawaban` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `modul_10_zr`
--

INSERT INTO `modul_10_zr` (`id`, `soal_id`, `nomor_soal`, `teks_soal`, `pilihan`, `kunci_jawaban`) VALUES
(1, 18, 81, '6	9	12	15	18	21	24	?', '26;37;27;28;25;', 'c'),
(2, 18, 82, '15	16	18	19	21	22	24	?', '23;24;26;25;27;', 'd'),
(3, 18, 83, '19	18	22	21	25	24	28	?', '25;36;27;34;28;', 'c'),
(4, 18, 84, '16	12	17	13	18	14	19	?', '15;13;26;24;17;', 'a'),
(5, 18, 85, '2	4	8	10	20	22	44	?', '54;46;64;44;45;', 'b'),
(6, 18, 86, '15	13	16	12	17	11	18	?', '12;14;10;8;21;', 'c'),
(7, 18, 87, '25	22	11	33	30	15	45	?', '24;32;26;42;44;', 'a'),
(8, 18, 88, '49	51	54	27	8	11	14	?', '14;9;7;16;8;', 'c'),
(9, 18, 89, '2	3	1	3	4	2	4	?', '12;5;6;14;7;', 'b'),
(10, 18, 90, '19	17	20	16	21	15	22	?', '24;22;34;14;16;', 'd'),
(11, 18, 91, '94	92	46	44	22	20	10	?', '9;8;7;11;6;', 'b'),
(12, 18, 92, '5	8	9	8	11	12	11	?', '16;14;10;18;12;', 'b'),
(13, 18, 93, '12	15	19	23	28	33	39	?', '34;44;54;45;14;', 'd'),
(14, 18, 94, '2	5	10	7	21	17	68	?', '32;34;44;54;14;', 'd'),
(15, 18, 95, '11	15	18	9	13	16	8	?', '23;12;8;36;17;', 'b'),
(16, 18, 96, '3	8	15	24	35	48	63	?', '72;85;80;65;42;', 'c'),
(17, 18, 97, '4	5	7	4	8	13	7	?', '14;24;16;36;25;', 'a'),
(18, 18, 98, '8	5	15	18	6	3	9	?', '24;12;14;26;16;', 'a'),
(19, 18, 100, '5	35	28	4	11	77	70	?', '12;14;11;10;8;', 'd');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peserta`
--

CREATE TABLE `peserta` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `username_peserta` varchar(100) NOT NULL,
  `password_peserta` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `nama_peserta` varchar(100) NOT NULL,
  `usia_peserta` int(5) NOT NULL,
  `pendidikan_peserta` varchar(45) NOT NULL,
  `jenis_tes_peserta` enum('nonmanagerial','managerial','','') NOT NULL,
  `status_login` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `peserta`
--

INSERT INTO `peserta` (`id`, `room_id`, `username_peserta`, `password_peserta`, `email`, `nama_peserta`, `usia_peserta`, `pendidikan_peserta`, `jenis_tes_peserta`, `status_login`) VALUES
(1, 1, 'andre_513_1', 'mantap', 'andreirhamni09@gmail.com', 'Andre S Irhamni Wicaksana', 23, 'S1 Komputer', 'nonmanagerial', 1),
(2, 1, 'sdnaksjjkdshjkhkjad_858_1', 'C5Act6ct', 'andre@gmail.com', 'Sdnaksjjkdshjkhkjad', 23, 'S1 Hukum', 'nonmanagerial', 0),
(3, 0, 'andre_941_', 'p1RjtRaq', 'andreini@gmail.com', 'andre', 21, 'S1 Hukum', 'managerial', 0),
(4, 1, 'andre_696_1', 'BiohyC7f', 'andreini@gmail.com', 'andre', 21, 'S1 Hukum', 'managerial', 0),
(5, 3, 'andre_909_3', 'mantap', 'andre@gmail.com', 'andre', 1, 'S1 Hukum', 'nonmanagerial', 1),
(6, 3, 'andre_303_3', 'BY8yQru6', 'andre@gmail.com', 'andre septio', 7, 'S1 Hukum', 'managerial', 1),
(7, 4, 'andre_885_4', 'nvcSbxDt', 'andreirhamni09@gmail.com', 'andre', 31, 'S1', 'managerial', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `room`
--

CREATE TABLE `room` (
  `id` int(11) NOT NULL,
  `link_room` text NOT NULL,
  `nama_room` varchar(45) NOT NULL,
  `meeting_id_room` varchar(100) NOT NULL,
  `password_room` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `status_soal` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `room`
--

INSERT INTO `room` (`id`, `link_room`, `nama_room`, `meeting_id_room`, `password_room`, `tanggal`, `jam_mulai`, `jam_selesai`, `status_soal`) VALUES
(1, 'luar biasa', 'luar biasa', 'luar biasa', 'luar biasa', '2021-06-11', '05:22:21', '23:59:00', 's_1=1;s_2=1;s_3=1;s_4=1;s_5=0;s_6=0;s_7=0;s_8=0;s_9=0;s_10=0;s_11=0;s_12=0;s_13=0;s_14=0;s_15=0;s_16=0;s_17=0'),
(3, 'asdasd', 'asdnasjkdhkjdhs', 'asdasd', 'khsakjdhskjahjk', '2021-06-09', '09:24:00', '20:24:00', 's_1=1;s_2=1;s_3=1;s_4=1;s_5=1;s_6=1;s_7=1;s_8=1;s_9=1;s_10=1;s_11=1;s_12=0;s_13=0;s_14=0;s_15=0;s_16=0;s_17=0'),
(4, 'https://www.youtube.com/results?search_query=when+we+were+young+indomusik+gram', 'Psikotes Sesi 2', 'Eli minta duit 5 ribu', 'jksdh', '2021-06-11', '10:58:00', '14:58:00', 's_1=0;s_2=0;s_3=0;s_4=0;s_5=0;s_6=0;s_7=0;s_8=0;s_9=0;s_10=0;s_11=0;s_12=0;s_13=0;s_14=0;s_15=0;s_16=0;s_17=0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `soal`
--

CREATE TABLE `soal` (
  `id` int(11) NOT NULL,
  `urutan` int(11) NOT NULL,
  `nama_soal` varchar(45) NOT NULL,
  `deskripsi_soal` text NOT NULL,
  `durasi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `soal`
--

INSERT INTO `soal` (`id`, `urutan`, `nama_soal`, `deskripsi_soal`, `durasi`) VALUES
(1, 1, 'Modul 1', 'Mantap Sekali', 3600),
(2, 2, 'Modul 2', 'Ini adalah modul 2', 3600),
(3, 3, 'Modul 3', 'Mantap ', 3600),
(4, 4, 'Modul 4', 'Ini Adalah Modul 4', 3600),
(5, 5, 'Modul 5', 'Luar Biasa', 3600),
(7, 6, 'Modul 6', 'ini modul 6', 3600),
(8, 7, 'Modul 7', 'Ini modul 7', 3600),
(9, 9, 'Modul 9', 'Ini Modul 9', 3600),
(10, 8, 'Modul 8', 'Ini Modul 88', 3600),
(11, 10, 'Modul 10 SE', 'Ini Adalah modul 10', 3600),
(15, 11, 'Modul 10 WA', 'Ini Modul 10 Wa', 3600),
(16, 12, 'Modul 10 AN', 'Ini Modul 10 AN', 3600),
(17, 13, 'Modul 10 RA', 'Ini Modul 10 RA', 3600),
(18, 14, 'Modul 10 ZR', 'Ini Modul 10 ZR', 3600),
(19, 15, 'Modul 10 GE', 'Ini Modul 10 GE', 3600),
(20, 16, 'Modul 10 FA', 'Ini Modul FA', 3600),
(21, 17, 'Modul 10 WU', 'Ini Modul 10 WU', 3600);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `hapalan`
--
ALTER TABLE `hapalan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `modul_1`
--
ALTER TABLE `modul_1`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `modul_2`
--
ALTER TABLE `modul_2`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `modul_3`
--
ALTER TABLE `modul_3`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `modul_4`
--
ALTER TABLE `modul_4`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `modul_5`
--
ALTER TABLE `modul_5`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `modul_6`
--
ALTER TABLE `modul_6`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `modul_7`
--
ALTER TABLE `modul_7`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `modul_8`
--
ALTER TABLE `modul_8`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `modul_9`
--
ALTER TABLE `modul_9`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `modul_10_an`
--
ALTER TABLE `modul_10_an`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `modul_10_fa`
--
ALTER TABLE `modul_10_fa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `modul_10_ge`
--
ALTER TABLE `modul_10_ge`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `modul_10_ra`
--
ALTER TABLE `modul_10_ra`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `modul_10_se`
--
ALTER TABLE `modul_10_se`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `modul_10_wa`
--
ALTER TABLE `modul_10_wa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `modul_10_wu`
--
ALTER TABLE `modul_10_wu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `modul_10_zr`
--
ALTER TABLE `modul_10_zr`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `peserta`
--
ALTER TABLE `peserta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username_peserta`);

--
-- Indeks untuk tabel `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `soal`
--
ALTER TABLE `soal`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_soal` (`nama_soal`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `hapalan`
--
ALTER TABLE `hapalan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `modul_1`
--
ALTER TABLE `modul_1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `modul_2`
--
ALTER TABLE `modul_2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `modul_3`
--
ALTER TABLE `modul_3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT untuk tabel `modul_4`
--
ALTER TABLE `modul_4`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `modul_5`
--
ALTER TABLE `modul_5`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `modul_6`
--
ALTER TABLE `modul_6`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT untuk tabel `modul_7`
--
ALTER TABLE `modul_7`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT untuk tabel `modul_8`
--
ALTER TABLE `modul_8`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `modul_9`
--
ALTER TABLE `modul_9`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `modul_10_an`
--
ALTER TABLE `modul_10_an`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `modul_10_fa`
--
ALTER TABLE `modul_10_fa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `modul_10_ge`
--
ALTER TABLE `modul_10_ge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `modul_10_ra`
--
ALTER TABLE `modul_10_ra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `modul_10_se`
--
ALTER TABLE `modul_10_se`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `modul_10_wa`
--
ALTER TABLE `modul_10_wa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `modul_10_wu`
--
ALTER TABLE `modul_10_wu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `modul_10_zr`
--
ALTER TABLE `modul_10_zr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `peserta`
--
ALTER TABLE `peserta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `room`
--
ALTER TABLE `room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `soal`
--
ALTER TABLE `soal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
