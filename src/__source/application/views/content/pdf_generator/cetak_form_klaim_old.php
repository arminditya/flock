<?php
            $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetTitle('Form_Klaim');
            // $pdf->SetHeaderMargin(10);
            // $pdf->SetTopMargin(10);
            $pdf->setFooterMargin(20);
            $pdf->SetAutoPageBreak(true);
            $pdf->SetAuthor('Author');
            $pdf->SetDisplayMode('real', 'default');
            $pdf->AddPage();

            //$image_file = define ('K_PATH_IMAGES', '/images/');;
            //$PDF_HEADER_LOGO = $tcpdf->Image('@' . $img);//any image file. check correct path.
            $PDF_HEADER_LOGO = 
            $PDF_HEADER_LOGO_WIDTH = "40";
            $PDF_HEADER_TITLE = "This is my Title";
            $PDF_HEADER_STRING = "This is Header Part";
            $pdf->SetHeaderData($PDF_HEADER_LOGO, $PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING);

            //$bertindaksebagai = $bertindaksebagai;


            //--- BEGIN - DI BAWAH UNTUK ATUR KONTENNYA ---// 

            //--- BEGIN - DEKLARASI VARIABLE ---// 
            $KdFormKlaim = '';
            $bertindaksebagai = '';
            $namapesertaklaim = '';
            $tanggallahir = '';
            $namamitra = '';
            $nip = '';
            $nomorktp = '';
            $npwp = '';
            $telprumah = '';
            $telphp = '';
            $berhentisejak = '';
            $norek = '';
            $anrek = '';
            $namabank = '';
            $namacabang = '';
            $isKpstLebih3Tahun = 0;
            $isUmurLebih45Tahun = 0;
            $dplk = '';
            $asuransijiwa = '';
            $namapemohon = '';
            $d_now = 0;
            $m_now = 0;
            $y_now = 0;
            //--- END - DEKLARASI VARIABLE ---// 

            foreach ($klaim as $data) 
            {
                $bertindaksebagai = $data->bertindaksebagai;
                $namapesertaklaim = $data->namapesertaklaim;
                $tanggallahir = $data->tanggallahir;
                $namamitra = $data->namamitra;
                $nip = $data->nip;
                $nomorktp = $data->nomorktp;
                $npwp = $data->npwp;
                $telprumah = $data->telprumah;
                $telphp = $data->telphp;
                $berhentisejak = $data->berhentisejak;
                $norek = $data->norek;
                $anrek = $data->anrek;
                $namabank = $data->namabank;
                $namacabang = $data->namacabang;
                $isKpstLebih3Tahun = $data->isKpstLebih3Tahun;
                $isUmurLebih45Tahun = $data->isUmurLebih45Tahun;
                $dplk = $data->dplk;
                $asuransijiwa = $data->asuransijiwa;
                $namapemohon = $data->namapemohon;
                $d_now = $data->d_now;
                $m_now = $data->m_now;
                $y_now = $data->y_now;

                if($m_now == '1'){
                    $m_string_now = "Januari";
                }else if($m_now == '2'){
                    $m_string_now = "Februari";
                }else if($m_now == '3'){
                    $m_string_now = "Maret";
                }else if($m_now == '4'){
                    $m_string_now = "April";
                }else if($m_now == '5'){
                    $m_string_now = "Mei";
                }else if($m_now == '6'){
                    $m_string_now = "Juni";
                }else if($m_now == '7'){
                    $m_string_now = "Juli";
                }else if($m_now == '8'){
                    $m_string_now = "Agustus";
                }else if($m_now == '9'){
                    $m_string_now = "September";
                }else if($m_now == '10'){
                    $m_string_now = "Oktober";
                }else if($m_now == '11'){
                    $m_string_now = "November";
                }else if($m_now == '12'){
                    $m_string_now = "Desember";
                }else{
                    $m_string_now = " ";
                }

                $date = $d_now." - ".$m_string_now." - ".$y_now;
            }
            

            
            $html='
        
            <div class="column">

            <p>Saya yang bertanda tangan di bawah ini, bertindak sebagai:</p>
            <p><em><strong>'.$bertindaksebagai.'</strong></em></p>

            <p>Dengan ini mengajukan Klaim Manfaat Pensiun atas kepesertaan dari:</p>

            <table style="width: 471px;">
                <tbody>
                    <tr>
                        <td style="width: 192px;">Nama Peserta (sesuai KTP)</td>
                        <td style="width: 275px;">: <em><strong>'.$namapesertaklaim.'</strong></em></td>
                    </tr>
                    <tr>
                        <td style="width: 192px;">Tgl Lahir</td>
                        <td style="width: 275px;">: <em><strong>'.$tanggallahir.'</strong></em></td>
                    </tr>
                    <tr>
                        <td style="width: 192px;">Nama Perusahaan</td>
                        <td style="width: 275px;">: <em><strong>'.$namamitra.'</strong></em></td>
                    </tr>
                    <tr>
                        <td style="width: 192px;">Nomor Induk Karyawan</td>
                        <td style="width: 275px;">: <strong><em>'.$nip.'</em></strong></td>
                    </tr>
                    <tr>
                        <td style="width: 192px;">Nomor KTP</td>
                        <td style="width: 275px;">: <em><strong>'.$nomorktp.'</strong></em></td>
                    </tr>
                    <tr>
                        <td style="width: 192px;">NPWP</td>
                        <td style="width: 275px;">: <em><strong>'.$npwp.'</strong></em></td>
                    </tr>
                    <tr>
                        <td style="width: 192px;">Telepon Aktif (Rumah)</td>
                        <td style="width: 275px;">: <em><strong>'.$telprumah.'</strong></em></td>
                    </tr>
                    <tr>
                        <td style="width: 192px;">Telepon Aktif (HP)</td>
                        <td style="width: 275px;">: <em><strong>'.$telphp.'</strong></em></td>
                    </tr>
                    <tr>
                        <td style="width: 192px;">Berhenti Sejak</td>
                        <td style="width: 275px;">: <em><strong>'.$berhentisejak.'</strong></em></td>
                    </tr>
                </tbody>
            </table>

            <p>Mohon untuk dibayarkan Manfaat Pensiun saya, sesuai dengan ketentuan Dana Pensiun Astra melalui rekening berikut:</p>
            <table style="width: 469px;">
                <tbody>
                    <tr>
                        <td style="width: 194px;">Nomor Rekening</td>
                        <td style="width: 269px;">: <em><strong>'.$norek.'</strong></em></td>
                    </tr>
                    <tr>
                        <td style="width: 194px;">Nama Pemilik Rekening</td>
                        <td style="width: 269px;">: <em><strong>'.$anrek.'</strong></em></td>
                    </tr>
                    <tr>
                        <td style="width: 194px;">Nama Bank</td>
                        <td style="width: 269px;">: <em><strong>'.$namabank.'</strong></em></td>
                    </tr>
                    <tr>
                        <td style="width: 194px;">Cabang</td>
                        <td style="width: 269px;">: <em><strong>'.$namacabang.'</strong></em></td>
                    </tr>
                </tbody>
            </table>

            <p>Jika masa kepesertaan lebih dari 3 tahun dan saat ini belum mencapai usia 45 tahun, mohon Manfaat Pensiun saya dialihkan ke:</p>
            <p>DPLK <em><strong>'.$dplk.'</strong></em></p>
            
            <p>(Bagi Peserta DPA 2 yang memiliki masa kepesertaan lebih dari 3 tahun dan telah mencapai usia 45 tahun, serta 80% Manfaat Pensiun melebihi Rp. 500.000.000, maka mengisi pilihan di bawah ini)<br /> Saya mohon 80% dari Manfaat Pensiun saya dibelikan produk Anuitas pilihan saya dari perusahaan Asuransi Jiwa sebagai berikut:</p>
            <p>Asuransi Jiwa <em><strong>'.$asuransijiwa.'</strong></em></p>

            <table style="width: 608px;">
                <tbody>
                    <tr style="height: 18px;">
                        <td style="height: 18px; text-align: center; width: 300px;"></td>
                        <td style="height: 18px; text-align: center; width: 200px;">'.$date.'</td>
                    </tr>
                </tbody>
            </table>

            <table style="width: 608px;">
                <tbody>
                    <tr style="height: 18px;">
                        <td style="height: 18px; text-align: center; width: 200px;">Pemohon</td>
                        <td style="height: 18px; text-align: center; width: 100px;">&nbsp;</td>
                        <td style="height: 18px; text-align: center; width: 200px;">Mengetahui</td>
                    </tr>
                    <tr style="height: 62px;">
                        <td style="height: 62px; width: 200px;">&nbsp;</td>
                        <td style="height: 62px; width: 100px;">&nbsp;</td>
                        <td style="height: 62px; width: 200px">&nbsp;</td>
                    </tr>
                    <tr style="height: 18px;">
                        <td style="height: 18px; text-align: center; width: 200px"><em><strong>'.$namapemohon.'</strong></em></td>
                        <td style="height: 18px; text-align: center; width: 100px;">&nbsp;</td>
                        <td style="height: 18px; text-align: center; width: 200px">&nbsp;</td>
                    </tr>
                    <tr style="height: 18px;">
                        <td style="height: 18px; text-align: center; width: 200px">&nbsp;</td>
                        <td style="height: 18px; text-align: center; width: 100px;">&nbsp;</td>
                        <td style="height: 18px; text-align: center; width: 200px"><font size="8">Tanda Tangan dan Cap Perusahaan</font></td>
                    </tr>
                    <tr style="height: 10px;">
                        <td style="height: 10px; text-align: center; width: 200px">&nbsp;</td>
                        <td style="height: 10px; text-align: center; width: 100px;">&nbsp;</td>
                        <td style="height: 10px; text-align: center; width: 200px"><font size="8">Tidak perlu tanda tangan HRD jika sudah tidak bekerja di perusahaan</font></td>
                    </tr>
                </tbody>
            </table>

            <p></p>
            <p></p>
            <p><font size="7">*) Informasi tentang DPLK dan Asuransi Jiwa yang ada dalam daftar OJK (Otoritas Jasa Keuangan) dapat dilihat pada web www.dapenastra.com</font></p>
            </div>
 
            
            ';
            //$html='<h2>'.$bertindaksebagai.'</h2>';
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output('formklaim.pdf', 'I');

            //--- BEGIN - DI BAWAH UNTUK ATUR KONTENNYA ---// 

?>
