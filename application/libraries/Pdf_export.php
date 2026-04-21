<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';

use Mpdf\Mpdf;

class Pdf_export
{

    protected $mpdf;

    public function __construct()
    {
        $this->mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'L',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 15,
            'margin_footer' => 5
        ]);
    }

    public function generate($html, $filename = 'laporan.pdf', $output = 'D')
    {
        $CI =& get_instance();
        $CI->load->helper('tanggal');

        $settings = $CI->config->item('settings');
        $nama_lksa = $settings->nama_lksa ?? 'LKSA Harapan Bangsa';

        $kop_html = '';
        if (!empty($settings->kop_surat)) {
            $kop_path = FCPATH . 'assets/uploads/kop/' . $settings->kop_surat;
            if (file_exists($kop_path)) {
                $kop_data = base64_encode(file_get_contents($kop_path));
                $kop_ext = pathinfo($kop_path, PATHINFO_EXTENSION);
                $mime = ($kop_ext == 'png') ? 'image/png' : 'image/jpeg';

                $kop_html = '<div style="text-align: center; margin-bottom: 10px;">
                    <img src="data:' . $mime . ';base64,' . $kop_data . '" style="max-width: 100%; height: auto;" />
                </div>';
            } else {
                $kop_html = $this->get_text_header($settings, $nama_lksa);
            }
        } else {
            $kop_html = $this->get_text_header($settings, $nama_lksa);
        }

        $full_html = $kop_html . $html;

        $this->mpdf->SetHTMLFooter('
        <div style="text-align: center; font-size: 10px;">
            Halaman {PAGENO} dari {nbpg} | Dicetak pada ' . tanggal_indo(date('Y-m-d H:i:s')) . '
        </div>');

        $this->mpdf->WriteHTML($full_html);
        $this->mpdf->Output($filename, $output);
    }

    public function generate_to_file($html, $filepath)
    {
        $CI =& get_instance();
        $CI->load->helper('tanggal');

        $settings = $CI->config->item('settings');
        $nama_lksa = $settings->nama_lksa ?? 'LKSA Harapan Bangsa';

        $kop_html = '';
        if (!empty($settings->kop_surat)) {
            $kop_path = FCPATH . 'assets/uploads/kop/' . $settings->kop_surat;
            if (file_exists($kop_path)) {
                $kop_data = base64_encode(file_get_contents($kop_path));
                $kop_ext = pathinfo($kop_path, PATHINFO_EXTENSION);
                $mime = ($kop_ext == 'png') ? 'image/png' : 'image/jpeg';

                $kop_html = '<div style="text-align: center; margin-bottom: 10px;">
                    <img src="data:' . $mime . ';base64,' . $kop_data . '" style="max-width: 100%; height: auto;" />
                </div>';
            } else {
                $kop_html = $this->get_text_header($settings, $nama_lksa);
            }
        } else {
            $kop_html = $this->get_text_header($settings, $nama_lksa);
        }

        $full_html = $kop_html . $html;

        $this->mpdf->SetHTMLFooter('
        <div style="text-align: center; font-size: 10px;">
            Halaman {PAGENO} dari {nbpg} | Dicetak pada ' . tanggal_indo(date('Y-m-d H:i:s')) . '
        </div>');

        $this->mpdf->WriteHTML($full_html);
        $this->mpdf->Output($filepath, 'F');
    }

    private function get_text_header($settings, $nama_lksa)
    {
        return '<div style="text-align: center; border-bottom: 2px solid #000; padding-bottom: 5px;">
            <h3 style="margin: 0; font-size: 16px;">' . $nama_lksa . '</h3>
            <p style="margin: 3px 0; font-size: 10px;">' . ($settings->alamat ?? '') . '</p>
            <p style="margin: 3px 0; font-size: 10px;">Telp: ' . ($settings->no_telp ?? '') . ' | Email: ' . ($settings->email ?? '') . '</p>
        </div>';
    }

    public function generate_laporan_anak($data)
    {
        $CI =& get_instance();
        $CI->load->helper('tanggal');

        $putra = array_values(array_filter($data['anak'], function ($a) {
            return strtoupper((string) ($a->jenis_kelamin ?? '')) === 'L';
        }));
        $putri = array_values(array_filter($data['anak'], function ($a) {
            return strtoupper((string) ($a->jenis_kelamin ?? '')) === 'P';
        }));

        usort($putra, function ($a, $b) {
            return strcasecmp((string) ($a->nama_anak ?? ''), (string) ($b->nama_anak ?? ''));
        });
        usort($putri, function ($a, $b) {
            return strcasecmp((string) ($a->nama_anak ?? ''), (string) ($b->nama_anak ?? ''));
        });

        $total_anak = count($data['anak']);
        $total_putra = count($putra);
        $total_putri = count($putri);

        $total_aktif = 0;
        $total_nonaktif = 0;
        $status_tinggal_counts = array();
        $kategori_counts = array();
        $pendidikan_counts = array();

        foreach ($data['anak'] as $a) {
            if (($a->status_anak ?? '') === 'Aktif') {
                $total_aktif++;
            } else {
                $total_nonaktif++;
            }

            $status_tinggal = trim((string) ($a->status_tinggal ?? ''));
            $status_tinggal = $status_tinggal !== '' ? $status_tinggal : '-';
            if (!isset($status_tinggal_counts[$status_tinggal])) {
                $status_tinggal_counts[$status_tinggal] = 0;
            }
            $status_tinggal_counts[$status_tinggal]++;

            $kategori = trim((string) ($a->kategori ?? ''));
            $kategori = $kategori !== '' ? $kategori : '-';
            if (!isset($kategori_counts[$kategori])) {
                $kategori_counts[$kategori] = 0;
            }
            $kategori_counts[$kategori]++;

            $pendidikan = trim((string) ($a->pendidikan ?? ''));
            $pendidikan = $pendidikan !== '' ? $pendidikan : '-';
            if (!isset($pendidikan_counts[$pendidikan])) {
                $pendidikan_counts[$pendidikan] = 0;
            }
            $pendidikan_counts[$pendidikan]++;
        }

        arsort($status_tinggal_counts);
        arsort($kategori_counts);
        arsort($pendidikan_counts);

        $render_distribution_table = function ($title, $label_col, $items, $base_total) {
            $table_html = '
        <h4 style="margin-top: 16px; margin-bottom: 8px;">' . $title . '</h4>
        <table border="1" cellpadding="4" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 10px; margin-bottom: 12px;">
            <thead style="background-color: #e0e0e0;">
                <tr>
                    <th style="text-align: center; width: 50%;">' . $label_col . '</th>
                    <th style="text-align: center; width: 25%;">Jumlah</th>
                    <th style="text-align: center; width: 25%;">Persentase</th>
                </tr>
            </thead>
            <tbody>';

            if (empty($items)) {
                $table_html .= '<tr><td colspan="3" style="text-align:center;">Tidak ada data.</td></tr>';
            } else {
                foreach ($items as $label => $jumlah) {
                    $persen = $base_total > 0 ? round(((float) $jumlah / (float) $base_total) * 100, 1) : 0;
                    $table_html .= '<tr>
                        <td>' . $label . '</td>
                        <td style="text-align: center;">' . $jumlah . '</td>
                        <td style="text-align: center;">' . $persen . '%</td>
                    </tr>';
                }
            }

            $table_html .= '</tbody></table>';
            return $table_html;
        };

        $html = '
        <h3 style="text-align: center; margin-bottom: 20px;">LAPORAN DATA ANAK ASUH</h3>
        <p style="text-align: center; margin-bottom: 20px;">Periode: ' . bulan_indo(date('n')) . ' ' . date('Y') . '</p>
        <h4 style="margin: 10px 0 8px 0;">Rekap Data</h4>
        <table border="1" cellpadding="4" cellspacing="0" style="width: 55%; border-collapse: collapse; font-size: 10px; margin-bottom: 16px;">
            <tr style="background-color: #f0f0f0;">
                <th style="text-align: left; width: 70%;">Keterangan</th>
                <th style="text-align: center; width: 30%;">Jumlah</th>
            </tr>
            <tr>
                <td>Total Anak</td>
                <td style="text-align: center;">' . $total_anak . '</td>
            </tr>
            <tr>
                <td>Total Putra</td>
                <td style="text-align: center;">' . $total_putra . '</td>
            </tr>
            <tr>
                <td>Total Putri</td>
                <td style="text-align: center;">' . $total_putri . '</td>
            </tr>
            <tr>
                <td>Total Aktif</td>
                <td style="text-align: center;">' . $total_aktif . '</td>
            </tr>
            <tr>
                <td>Total Nonaktif</td>
                <td style="text-align: center;">' . $total_nonaktif . '</td>
            </tr>
        </table>';

        $html .= '
        <h4 style="margin-top: 16px; margin-bottom: 8px;">Statistik Jenis Kelamin</h4>
        <table border="1" cellpadding="4" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 10px; margin-bottom: 12px;">
            <thead style="background-color: #e0e0e0;">
                <tr>
                    <th style="text-align: center; width: 50%;">Jenis Kelamin</th>
                    <th style="text-align: center; width: 25%;">Jumlah</th>
                    <th style="text-align: center; width: 25%;">Persentase</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Putra</td>
                    <td style="text-align: center;">' . $total_putra . '</td>
                    <td style="text-align: center;">' . ($total_anak > 0 ? round(($total_putra / $total_anak) * 100, 1) : 0) . '%</td>
                </tr>
                <tr>
                    <td>Putri</td>
                    <td style="text-align: center;">' . $total_putri . '</td>
                    <td style="text-align: center;">' . ($total_anak > 0 ? round(($total_putri / $total_anak) * 100, 1) : 0) . '%</td>
                </tr>
            </tbody>
        </table>';

        $html .= $render_distribution_table('Statistik Status Tinggal', 'Status Tinggal', $status_tinggal_counts, $total_anak);
        $html .= $render_distribution_table('Statistik Kategori', 'Kategori', $kategori_counts, $total_anak);
        $html .= $render_distribution_table('Statistik Pendidikan', 'Tingkat Pendidikan', $pendidikan_counts, $total_anak);

        $render_anak_table = function ($title, $rows) {
            $table_html = '
        <h4 style="margin: 10px 0 8px 0;">' . $title . '</h4>
        <table border="1" cellpadding="3" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 9px; margin-bottom: 16px;">
            <thead style="background-color: #f0f0f0;">
                <tr>
                    <th style="width: 3%;">No</th>
                    <th style="width: 8%;">NIK</th>
                    <th style="width: 8%;">No KK</th>
                    <th style="width: 12%;">Nama Anak</th>
                    <th style="width: 5%;">JK</th>
                    <th style="width: 10%;">Tempat/Tgl Lahir</th>
                    <th style="width: 4%;">Usia</th>
                    <th style="width: 6%;">Pendidikan</th>
                    <th style="width: 6%;">Kategori</th>
                    <th style="width: 5%;">Status</th>
                    <th style="width: 7%;">Status Tinggal</th>
                    <th style="width: 7%;">Tgl Masuk</th>
                    <th style="width: 6%;">Nama Sekolah</th>
                    <th style="width: 6%;">Biaya SPP</th>
                    <th style="width: 4%;">KK</th>
                    <th style="width: 4%;">Akta</th>
                    <th style="width: 6%;">Dok Pendukung</th>
                    <th style="width: 4%;">Foto</th>
                </tr>
            </thead>
            <tbody>';

            if (empty($rows)) {
                $table_html .= '<tr><td colspan="18" style="text-align: center;">Tidak ada data.</td></tr>';
            } else {
                $no = 1;
                foreach ($rows as $a) {
                    $table_html .= '
                <tr>
                    <td style="text-align: center;">' . $no++ . '</td>
                    <td>' . ($a->nik ?: '-') . '</td>
                    <td>' . ($a->no_kk ?: '-') . '</td>
                    <td>' . $a->nama_anak . '</td>
                    <td style="text-align: center;">' . ($a->jenis_kelamin == 'L' ? 'L' : 'P') . '</td>
                    <td>' . $a->tempat_lahir . ', ' . tanggal_indo($a->tanggal_lahir) . '</td>
                    <td style="text-align: center;">' . umur($a->tanggal_lahir) . '</td>
                    <td>' . $a->pendidikan . '</td>
                    <td>' . ($a->kategori ?: '-') . '</td>
                    <td style="text-align: center;">' . $a->status_anak . '</td>
                    <td>' . ($a->status_tinggal ?: '-') . '</td>
                    <td style="text-align: center;">' . tanggal_indo($a->tanggal_masuk) . '</td>
                    <td>' . ($a->nama_sekolah ?: '-') . '</td>
                    <td style="text-align: center;">' . ($a->biaya_spp ? 'Rp ' . number_format($a->biaya_spp, 0, ',', '.') : '-') . '</td>
                    <td style="text-align: center;">' . (!empty($a->file_kk) ? 'Ada' : 'Tidak') . '</td>
                    <td style="text-align: center;">' . (!empty($a->file_akta) ? 'Ada' : 'Tidak') . '</td>
                    <td style="text-align: center;">' . (!empty($a->file_pendukung) ? 'Ada' : 'Tidak') . '</td>
                    <td style="text-align: center;">' . (!empty($a->foto) ? 'Ada' : 'Tidak') . '</td>
                </tr>';
                }
            }

            $table_html .= '
            </tbody>
        </table>';

            return $table_html;
        };

        $html .= $render_anak_table('Kelompok Putra', $putra);
        $html .= $render_anak_table('Kelompok Putri', $putri);

        $html .= '

        <div style="margin-top: 20px; text-align: right;">
            <p>' . ($data['settings']->kota ?? '............') . ', ' . tanggal_indo(date('Y-m-d')) . '</p>
            <p style="margin-top: 40px;"><strong>' . ($data['settings']->nama_kepala ?? 'Kepala LKSA') . '</strong></p>
            <p>Kepala ' . ($data['settings']->nama_lksa ?? 'LKSA') . '</p>
        </div>';

        return $html;
    }

    public function generate_laporan_pengurus($data)
    {
        $CI =& get_instance();
        $CI->load->helper('tanggal');

        // Create new Mpdf instance with portrait orientation
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P', // Portrait
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 15,
            'margin_bottom' => 15,
            'margin_footer' => 5
        ]);

        $settings = $CI->config->item('settings');
        $nama_lksa = $settings->nama_lksa ?? 'LKSA Harapan Bangsa';

        $kop_html = '';
        if (!empty($settings->kop_surat)) {
            $kop_path = FCPATH . 'assets/uploads/kop/' . $settings->kop_surat;
            if (file_exists($kop_path)) {
                $kop_data = base64_encode(file_get_contents($kop_path));
                $kop_ext = pathinfo($kop_path, PATHINFO_EXTENSION);
                $mime = ($kop_ext == 'png') ? 'image/png' : 'image/jpeg';

                $kop_html = '<div style="text-align: center; margin-bottom: 10px;">
                    <img src="data:' . $mime . ';base64,' . $kop_data . '" style="max-width: 100%; height: auto;" />
                </div>';
            } else {
                $kop_html = $this->get_text_header($settings, $nama_lksa);
            }
        } else {
            $kop_html = $this->get_text_header($settings, $nama_lksa);
        }

        $html = $kop_html . '
        <h3 style="text-align: center; margin-bottom: 20px;">LAPORAN DATA PENGURUS</h3>
        <p style="text-align: center; margin-bottom: 20px;">Periode: ' . bulan_indo(date('n')) . ' ' . date('Y') . '</p>

        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 11px;">
            <thead style="background-color: #f0f0f0;">
                <tr>
                    <th style="width: 5%; text-align: center;">No</th>
                    <th style="width: 25%;">Nama Pengurus</th>
                    <th style="width: 20%;">Jabatan</th>
                    <th style="width: 15%;">No HP</th>
                    <th style="width: 20%;">Email</th>
                    <th style="width: 10%; text-align: center;">KTP</th>
                    <th style="width: 15%; text-align: center;">Tgl Bergabung</th>
                </tr>
            </thead>
            <tbody>';

        $no = 1;
        foreach ($data['pengurus'] as $p) {
            $html .= '
                <tr>
                    <td style="text-align: center;">' . $no++ . '</td>
                    <td>' . $p->nama_pengurus . '</td>
                    <td>' . $p->jabatan . '</td>
                    <td>' . $p->no_hp . '</td>
                    <td>' . ($p->email ?: '-') . '</td>
                    <td style="text-align: center;">' . (!empty($p->file_ktp) ? 'Ada' : 'Belum') . '</td>
                    <td style="text-align: center;">' . tanggal_indo($p->created_at) . '</td>
                </tr>';
        }

        $html .= '
            </tbody>
        </table>

        <div style="margin-top: 30px; text-align: right;">
            <p>' . ($data['settings']->kota ?? '............') . ', ' . tanggal_indo(date('Y-m-d')) . '</p>
            <p style="margin-top: 50px;"><strong>' . ($data['settings']->nama_kepala ?? 'Kepala LKSA') . '</strong></p>
            <p>Kepala ' . ($data['settings']->nama_lksa ?? 'LKSA') . '</p>
        </div>';

        $mpdf->SetHTMLFooter('
        <div style="text-align: center; font-size: 9px;">
            Halaman {PAGENO} dari {nbpg} | Dicetak pada ' . tanggal_indo(date('Y-m-d H:i:s')) . '
        </div>');

        $mpdf->WriteHTML($html);
        $mpdf->Output('laporan_pengurus_' . date('Ymd') . '.pdf', 'D');
        exit;
    }

    public function generate_laporan_dokumen($data)
    {
        $CI =& get_instance();
        $CI->load->helper('tanggal');

        // Create new Mpdf instance with portrait orientation
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P', // Portrait
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 15,
            'margin_bottom' => 15,
            'margin_footer' => 5
        ]);

        $settings = $CI->config->item('settings');
        $nama_lksa = $settings->nama_lksa ?? 'LKSA Harapan Bangsa';

        $kop_html = '';
        if (!empty($settings->kop_surat)) {
            $kop_path = FCPATH . 'assets/uploads/kop/' . $settings->kop_surat;
            if (file_exists($kop_path)) {
                $kop_data = base64_encode(file_get_contents($kop_path));
                $kop_ext = pathinfo($kop_path, PATHINFO_EXTENSION);
                $mime = ($kop_ext == 'png') ? 'image/png' : 'image/jpeg';

                $kop_html = '<div style="text-align: center; margin-bottom: 10px;">
                    <img src="data:' . $mime . ';base64,' . $kop_data . '" style="max-width: 100%; height: auto;" />
                </div>';
            } else {
                $kop_html = $this->get_text_header($settings, $nama_lksa);
            }
        } else {
            $kop_html = $this->get_text_header($settings, $nama_lksa);
        }

        $html = $kop_html . '
        <h3 style="text-align: center; margin-bottom: 20px;">LAPORAN KELENGKAPAN DOKUMEN ANAK</h3>
        <p style="text-align: center; margin-bottom: 20px;">Periode: ' . bulan_indo(date('n')) . ' ' . date('Y') . '</p>

        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 11px;">
            <thead style="background-color: #f0f0f0;">
                <tr>
                    <th style="width: 5%; text-align: center;">No</th>
                    <th style="width: 25%;">Nama Anak</th>
                    <th style="width: 20%;">NIK</th>
                    <th style="width: 15%; text-align: center;">KK</th>
                    <th style="width: 15%; text-align: center;">Akta</th>
                    <th style="width: 15%; text-align: center;">Pendukung</th>
                    <th style="width: 15%; text-align: center;">Status</th>
                </tr>
            </thead>
            <tbody>';

        $no = 1;
        foreach ($data['anak'] as $a) {
            $lengkap = !empty($a->file_kk) && !empty($a->file_akta);
            $html .= '
                <tr>
                    <td style="text-align: center;">' . $no++ . '</td>
                    <td>' . $a->nama_anak . '</td>
                    <td>' . ($a->nik ?: '-') . '</td>
                    <td style="text-align: center;">' . (!empty($a->file_kk) ? '✓ Ada' : '✗ Belum') . '</td>
                    <td style="text-align: center;">' . (!empty($a->file_akta) ? '✓ Ada' : '✗ Belum') . '</td>
                    <td style="text-align: center;">' . (!empty($a->file_pendukung) ? '✓ Ada' : '-') . '</td>
                    <td style="text-align: center;">' . ($lengkap ? 'Lengkap' : 'Kurang') . '</td>
                </tr>';
        }

        $html .= '
            </tbody>
        </table>

        <div style="margin-top: 30px; text-align: right;">
            <p>' . ($data['settings']->kota ?? '............') . ', ' . tanggal_indo(date('Y-m-d')) . '</p>
            <p style="margin-top: 50px;"><strong>' . ($data['settings']->nama_kepala ?? 'Kepala LKSA') . '</strong></p>
            <p>Kepala ' . ($data['settings']->nama_lksa ?? 'LKSA') . '</p>
        </div>';

        $mpdf->SetHTMLFooter('
        <div style="text-align: center; font-size: 9px;">
            Halaman {PAGENO} dari {nbpg} | Dicetak pada ' . tanggal_indo(date('Y-m-d H:i:s')) . '
        </div>');

        $mpdf->WriteHTML($html);
        $mpdf->Output('laporan_dokumen_' . date('Ymd') . '.pdf', 'D');
        exit;
    }

    public function generate_laporan_statistik($data)
    {
        $CI =& get_instance();
        $CI->load->helper('tanggal');

        $anak = $data['anak'];

        $total = count($anak);
        $laki = count(array_filter($anak, function ($a) {
            return $a->jenis_kelamin == 'L';
        }));
        $perempuan = count(array_filter($anak, function ($a) {
            return $a->jenis_kelamin == 'P';
        }));
        $aktif = count(array_filter($anak, function ($a) {
            return $a->status_anak == 'Aktif';
        }));

        $usia_dibawah5 = 0;
        $usia_5_12 = 0;
        $usia_13_17 = 0;
        $usia_diatas17 = 0;

        foreach ($anak as $a) {
            $usia = date_diff(date_create($a->tanggal_lahir), date_create('today'))->y;
            if ($usia < 5)
                $usia_dibawah5++;
            elseif ($usia <= 12)
                $usia_5_12++;
            elseif ($usia <= 17)
                $usia_13_17++;
            else
                $usia_diatas17++;
        }

        $pendidikan = array();
        foreach ($anak as $a) {
            $pend = $a->pendidikan;
            if (!isset($pendidikan[$pend]))
                $pendidikan[$pend] = 0;
            $pendidikan[$pend]++;
        }

        $html = '
        <h3 style="text-align: center; margin-bottom: 10px;">LAPORAN STATISTIK ANAK ASUH</h3>
        <p style="text-align: center; margin-bottom: 20px;">Periode: ' . bulan_indo(date('n')) . ' ' . date('Y') . '</p>
        
        <h4 style="margin-top: 20px; margin-bottom: 10px;">Ringkasan</h4>
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 20px;">
            <thead style="background-color: #e0e0e0;">
                <tr>
                    <th style="text-align: center;">Total Anak</th>
                    <th style="text-align: center;">Laki-laki</th>
                    <th style="text-align: center;">Perempuan</th>
                    <th style="text-align: center;">Status Aktif</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center; font-size: 14px;"><strong>' . $total . '</strong></td>
                    <td style="text-align: center;">' . $laki . ' (' . ($total > 0 ? round(($laki / $total) * 100) : 0) . '%)</td>
                    <td style="text-align: center;">' . $perempuan . ' (' . ($total > 0 ? round(($perempuan / $total) * 100) : 0) . '%)</td>
                    <td style="text-align: center;">' . $aktif . '</td>
                </tr>
            </tbody>
        </table>

        <h4 style="margin-top: 20px; margin-bottom: 10px;">Statistik Jenis Kelamin</h4>
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 20px;">
            <thead style="background-color: #e0e0e0;">
                <tr>
                    <th style="text-align: center;">Jenis Kelamin</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: center;">Persentase</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Laki-laki</td>
                    <td style="text-align: center;">' . $laki . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($laki / $total) * 100, 1) : 0) . '%</td>
                </tr>
                <tr>
                    <td>Perempuan</td>
                    <td style="text-align: center;">' . $perempuan . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($perempuan / $total) * 100, 1) : 0) . '%</td>
                </tr>
            </tbody>
        </table>

        <h4 style="margin-top: 20px; margin-bottom: 10px;">Statistik Usia</h4>
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 20px;">
            <thead style="background-color: #e0e0e0;">
                <tr>
                    <th style="text-align: center;">Kelompok Usia</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: center;">Persentase</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>0-4 tahun (Balita)</td>
                    <td style="text-align: center;">' . $usia_dibawah5 . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($usia_dibawah5 / $total) * 100, 1) : 0) . '%</td>
                </tr>
                <tr>
                    <td>5-12 tahun (Anak-anak)</td>
                    <td style="text-align: center;">' . $usia_5_12 . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($usia_5_12 / $total) * 100, 1) : 0) . '%</td>
                </tr>
                <tr>
                    <td>13-17 tahun (Remaja)</td>
                    <td style="text-align: center;">' . $usia_13_17 . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($usia_13_17 / $total) * 100, 1) : 0) . '%</td>
                </tr>
                <tr>
                    <td>18+ tahun (Dewasa)</td>
                    <td style="text-align: center;">' . $usia_diatas17 . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($usia_diatas17 / $total) * 100, 1) : 0) . '%</td>
                </tr>
            </tbody>
        </table>

        <h4 style="margin-top: 20px; margin-bottom: 10px;">Statistik Pendidikan</h4>
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 20px;">
            <thead style="background-color: #e0e0e0;">
                <tr>
                    <th style="text-align: center;">Tingkat Pendidikan</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: center;">Persentase</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($pendidikan as $pend => $jumlah) {
            $html .= '
                <tr>
                    <td>' . $pend . '</td>
                    <td style="text-align: center;">' . $jumlah . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($jumlah / $total) * 100, 1) : 0) . '%</td>
                </tr>';
        }

        $html .= '
            </tbody>
        </table>

        <div style="margin-top: 30px; text-align: right;">
            <p>' . ($data['settings']->kota ?? '............') . ', ' . tanggal_indo(date('Y-m-d')) . '</p>
            <p style="margin-top: 60px;"><strong>' . ($data['settings']->nama_kepala ?? 'Kepala LKSA') . '</strong></p>
            <p>Kepala ' . ($data['settings']->nama_lksa ?? 'LKSA') . '</p>
        </div>';

        return $html;
    }

    public function generate_laporan_karakter($data)
    {
        $CI =& get_instance();
        $CI->load->helper('tanggal');

        $weekly_reports = $data['weekly_reports'] ?? array();
        $monthly_reports = $data['monthly_reports'] ?? array();
        $settings = $data['settings'] ?? $CI->config->item('settings');

        $nama_lksa = $settings->nama_lksa ?? 'LKSA Harapan Bangsa';
        $nama_kepala = $settings->nama_kepala ?? 'Kepala Lembaga';
        $kota = $settings->kota ?? '....................';

        $total_weekly = count($weekly_reports);
        $total_monthly = count($monthly_reports);
        $total_data = $total_weekly + $total_monthly;

        $avg_weekly = 0;
        if ($total_weekly > 0) {
            $sum = 0;
            foreach ($weekly_reports as $r) {
                $sum += (float) $r->avg_score;
            }
            $avg_weekly = $sum / $total_weekly;
        }

        $avg_monthly = 0;
        if ($total_monthly > 0) {
            $sum = 0;
            foreach ($monthly_reports as $r) {
                $sum += (float) $r->avg_score;
            }
            $avg_monthly = $sum / $total_monthly;
        }

        $html = '
        <style>
            .report-title {
                text-align: center;
                font-weight: bold;
                font-size: 16px;
                margin-top: 8px;
                margin-bottom: 2px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            .report-subtitle {
                text-align: center;
                font-size: 11px;
                margin-bottom: 14px;
            }
            .meta-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 12px;
                font-size: 10px;
            }
            .meta-table td {
                padding: 4px 6px;
                border: 1px solid #d9d9d9;
            }
            .section-title {
                font-weight: bold;
                font-size: 12px;
                margin: 14px 0 8px;
                text-transform: uppercase;
            }
            .summary-table, .report-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 9px;
            }
            .summary-table th, .summary-table td,
            .report-table th, .report-table td {
                border: 1px solid #333;
                padding: 5px 6px;
            }
            .summary-table th,
            .report-table th {
                background: #f0f0f0;
                text-align: center;
                font-weight: bold;
            }
            .text-center { text-align: center; }
            .signature {
                width: 100%;
                margin-top: 20px;
                font-size: 10px;
            }
            .signature-right {
                width: 40%;
                margin-left: auto;
                text-align: center;
            }
            .page-break {
                page-break-before: always;
            }
        </style>

        <div class="report-title">Laporan Penilaian Karakter Anak</div>
        <div class="report-subtitle">' . strtoupper($nama_lksa) . ' | Tahun ' . date('Y') . '</div>

        <table class="meta-table">
            <tr>
                <td style="width: 22%;"><strong>Lembaga</strong></td>
                <td style="width: 78%;">' . $nama_lksa . '</td>
            </tr>
            <tr>
                <td><strong>Tanggal Cetak</strong></td>
                <td>' . tanggal_indo(date('Y-m-d H:i:s')) . '</td>
            </tr>
            <tr>
                <td><strong>Jenis Laporan</strong></td>
                <td>Rekap Mingguan dan Bulanan Penilaian Karakter</td>
            </tr>
        </table>

        <div class="section-title">A. Ringkasan Eksekutif</div>
        <table class="summary-table" cellspacing="0" cellpadding="0">
            <tr>
                <th>Total Data Mingguan</th>
                <th>Total Data Bulanan</th>
                <th>Total Data Laporan</th>
                <th>Rata-rata Mingguan</th>
                <th>Rata-rata Bulanan</th>
            </tr>
            <tr>
                <td class="text-center">' . $total_weekly . '</td>
                <td class="text-center">' . $total_monthly . '</td>
                <td class="text-center">' . $total_data . '</td>
                <td class="text-center">' . number_format($avg_weekly, 2) . '</td>
                <td class="text-center">' . number_format($avg_monthly, 2) . '</td>
            </tr>
        </table>

        <div class="section-title">B. Rekap Penilaian Mingguan</div>
        <table class="report-table" cellspacing="0" cellpadding="0">
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 22%;">Nama Anak</th>
                <th style="width: 22%;">Aspek</th>
                <th style="width: 8%;">Minggu</th>
                <th style="width: 8%;">Tahun</th>
                <th style="width: 10%;">Skor Rata-rata</th>
                <th style="width: 12%;">Kategori</th>
                <th style="width: 14%;">Tipe Assessor</th>
            </tr>';

        $no = 1;
        if (!empty($weekly_reports)) {
            foreach ($weekly_reports as $r) {
                $html .= '<tr>
                    <td class="text-center">' . $no++ . '</td>
                    <td>' . ($r->nama_anak ?: '-') . '</td>
                    <td>' . ($r->aspect_name ?: '-') . '</td>
                    <td class="text-center">' . ($r->week_number ?: '-') . '</td>
                    <td class="text-center">' . ($r->year ?: '-') . '</td>
                    <td class="text-center">' . number_format((float) $r->avg_score, 2) . '</td>
                    <td>' . ($r->category ?: '-') . '</td>
                    <td class="text-center">' . ucfirst(str_replace('_', ' ', $r->assessor_type ?: '-')) . '</td>
                </tr>';
            }
        } else {
            $html .= '<tr><td colspan="8" class="text-center">Belum ada data rekap mingguan.</td></tr>';
        }

        $html .= '</table>

        <div class="page-break"></div>

        <div class="section-title">C. Rekap Penilaian Bulanan</div>
        <table class="report-table" cellspacing="0" cellpadding="0">
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 24%;">Nama Anak</th>
                <th style="width: 24%;">Aspek</th>
                <th style="width: 8%;">Bulan</th>
                <th style="width: 8%;">Tahun</th>
                <th style="width: 10%;">Skor Rata-rata</th>
                <th style="width: 12%;">Kategori</th>
                <th style="width: 10%;">Tipe Assessor</th>
            </tr>';

        $no = 1;
        if (!empty($monthly_reports)) {
            foreach ($monthly_reports as $r) {
                $bulan = !empty($r->month) ? bulan_indo((int) $r->month) : '-';
                $html .= '<tr>
                    <td class="text-center">' . $no++ . '</td>
                    <td>' . ($r->nama_anak ?: '-') . '</td>
                    <td>' . ($r->aspect_name ?: '-') . '</td>
                    <td class="text-center">' . $bulan . '</td>
                    <td class="text-center">' . ($r->year ?: '-') . '</td>
                    <td class="text-center">' . number_format((float) $r->avg_score, 2) . '</td>
                    <td>' . ($r->category ?: '-') . '</td>
                    <td class="text-center">' . ucfirst(str_replace('_', ' ', $r->assessor_type ?: '-')) . '</td>
                </tr>';
            }
        } else {
            $html .= '<tr><td colspan="8" class="text-center">Belum ada data rekap bulanan.</td></tr>';
        }

        $html .= '</table>

        <div class="signature">
            <div class="signature-right">
                <p>' . $kota . ', ' . tanggal_indo(date('Y-m-d')) . '</p>
                <p><strong>Kepala Lembaga</strong></p>
                <br><br><br>
                <p><strong><u>' . $nama_kepala . '</u></strong></p>
            </div>
        </div>';

        return $html;
    }

    public function generate_laporan_statistik_with_charts($data)
    {
        $CI =& get_instance();
        $CI->load->helper('tanggal');

        $stats = $data['stats'];
        $chart_images = $data['chart_images'];

        $total = $stats['total'];
        $laki = $stats['laki'];
        $perempuan = $stats['perempuan'];
        $aktif = $stats['aktif'];
        $usia_dibawah5 = $stats['usia_dibawah5'];
        $usia_5_12 = $stats['usia_5_12'];
        $usia_13_17 = $stats['usia_13_17'];
        $usia_diatas17 = $stats['usia_diatas17'];
        $pendidikan = $stats['pendidikan'];

        $html = '
        <h3 style="text-align: center; margin-bottom: 10px;">LAPORAN STATISTIK ANAK ASUH</h3>
        <p style="text-align: center; margin-bottom: 20px;">Periode: ' . bulan_indo(date('n')) . ' ' . date('Y') . '</p>
        
        <h4 style="margin-top: 20px; margin-bottom: 10px;">Ringkasan</h4>
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 20px;">
            <thead style="background-color: #e0e0e0;">
                <tr>
                    <th style="text-align: center;">Total Anak</th>
                    <th style="text-align: center;">Laki-laki</th>
                    <th style="text-align: center;">Perempuan</th>
                    <th style="text-align: center;">Status Aktif</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center; font-size: 14px;"><strong>' . $total . '</strong></td>
                    <td style="text-align: center;">' . $laki . ' (' . ($total > 0 ? round(($laki / $total) * 100) : 0) . '%)</td>
                    <td style="text-align: center;">' . $perempuan . ' (' . ($total > 0 ? round(($perempuan / $total) * 100) : 0) . '%)</td>
                    <td style="text-align: center;">' . $aktif . '</td>
                </tr>
            </tbody>
        </table>';

        // Add Gender Chart Image
        if (!empty($chart_images['gender'])) {
            $html .= '
        <h4 style="margin-top: 20px; margin-bottom: 10px;">Grafik Jenis Kelamin</h4>
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="' . $chart_images['gender'] . '" style="max-width: 100%; height: auto; max-height: 250px;" />
        </div>';
        }

        // Add Age Chart Image
        if (!empty($chart_images['age'])) {
            $html .= '
        <h4 style="margin-top: 20px; margin-bottom: 10px;">Grafik Usia</h4>
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="' . $chart_images['age'] . '" style="max-width: 100%; height: auto; max-height: 250px;" />
        </div>';
        }

        // Add Education Chart Image
        if (!empty($chart_images['education'])) {
            $html .= '
        <h4 style="margin-top: 20px; margin-bottom: 10px;">Grafik Pendidikan</h4>
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="' . $chart_images['education'] . '" style="max-width: 100%; height: auto; max-height: 250px;" />
        </div>';
        }

        $html .= '
        <h4 style="margin-top: 20px; margin-bottom: 10px;">Statistik Jenis Kelamin</h4>
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 20px;">
            <thead style="background-color: #e0e0e0;">
                <tr>
                    <th style="text-align: center;">Jenis Kelamin</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: center;">Persentase</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Laki-laki</td>
                    <td style="text-align: center;">' . $laki . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($laki / $total) * 100, 1) : 0) . '%</td>
                </tr>
                <tr>
                    <td>Perempuan</td>
                    <td style="text-align: center;">' . $perempuan . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($perempuan / $total) * 100, 1) : 0) . '%</td>
                </tr>
            </tbody>
        </table>

        <h4 style="margin-top: 20px; margin-bottom: 10px;">Statistik Usia</h4>
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 20px;">
            <thead style="background-color: #e0e0e0;">
                <tr>
                    <th style="text-align: center;">Kelompok Usia</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: center;">Persentase</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>0-4 tahun (Balita)</td>
                    <td style="text-align: center;">' . $usia_dibawah5 . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($usia_dibawah5 / $total) * 100, 1) : 0) . '%</td>
                </tr>
                <tr>
                    <td>5-12 tahun (Anak-anak)</td>
                    <td style="text-align: center;">' . $usia_5_12 . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($usia_5_12 / $total) * 100, 1) : 0) . '%</td>
                </tr>
                <tr>
                    <td>13-17 tahun (Remaja)</td>
                    <td style="text-align: center;">' . $usia_13_17 . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($usia_13_17 / $total) * 100, 1) : 0) . '%</td>
                </tr>
                <tr>
                    <td>18+ tahun (Dewasa)</td>
                    <td style="text-align: center;">' . $usia_diatas17 . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($usia_diatas17 / $total) * 100, 1) : 0) . '%</td>
                </tr>
            </tbody>
        </table>

        <h4 style="margin-top: 20px; margin-bottom: 10px;">Statistik Pendidikan</h4>
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 20px;">
            <thead style="background-color: #e0e0e0;">
                <tr>
                    <th style="text-align: center;">Tingkat Pendidikan</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: center;">Persentase</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($pendidikan as $pend => $jumlah) {
            $html .= '
                <tr>
                    <td>' . $pend . '</td>
                    <td style="text-align: center;">' . $jumlah . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($jumlah / $total) * 100, 1) : 0) . '%</td>
                </tr>';
        }

        $html .= '
            </tbody>
        </table>

        <div style="margin-top: 30px; text-align: right;">
            <p>' . ($data['settings']->kota ?? '............') . ', ' . tanggal_indo(date('Y-m-d')) . '</p>
            <p style="margin-top: 60px;"><strong>' . ($data['settings']->nama_kepala ?? 'Kepala LKSA') . '</strong></p>
            <p>Kepala ' . ($data['settings']->nama_lksa ?? 'LKSA') . '</p>
        </div>';

        return $html;
    }

    public function generate_laporan_karakter_ringkasan($data)
    {
        $CI =& get_instance();
        $CI->load->helper('tanggal');

        $summary_rows = $data['summary_rows'] ?? array();
        $period_label = $data['period_label'] ?? '-';
        $settings = $data['settings'] ?? $CI->config->item('settings');

        $nama_lksa = $settings->nama_lksa ?? 'LKSA Harapan Bangsa';
        $nama_kepala = $settings->nama_kepala ?? 'Kepala Lembaga';
        $kota = $settings->kota ?? '....................';

        $total_anak = count($summary_rows);
        $total_penilaian = 0;
        $total_score = 0;
        foreach ($summary_rows as $row) {
            $total_penilaian += (int) ($row->total_penilaian ?? 0);
            $total_score += (float) ($row->avg_score ?? 0);
        }
        $rata_rata = $total_anak > 0 ? ($total_score / $total_anak) : 0;

        $html = '
        <style>
            .title { text-align:center; font-size:16px; font-weight:bold; text-transform:uppercase; margin:8px 0 2px; }
            .subtitle { text-align:center; font-size:11px; margin-bottom:12px; }
            .meta { width:100%; border-collapse:collapse; margin-bottom:10px; font-size:10px; }
            .meta td { border:1px solid #d9d9d9; padding:5px 6px; }
            .section { font-size:12px; font-weight:bold; margin:12px 0 6px; text-transform:uppercase; }
            .tbl { width:100%; border-collapse:collapse; font-size:9px; }
            .tbl th, .tbl td { border:1px solid #333; padding:5px 6px; }
            .tbl th { background:#f0f0f0; text-align:center; }
            .tc { text-align:center; }
            .signature { width:100%; margin-top:18px; font-size:10px; }
            .signature .right { width:40%; margin-left:auto; text-align:center; }
        </style>

        <div class="title">Laporan Ringkasan Perkembangan Karakter Anak</div>
        <div class="subtitle">' . strtoupper($nama_lksa) . '</div>

        <table class="meta">
            <tr><td style="width:22%;"><strong>Periode Laporan</strong></td><td>' . $period_label . '</td></tr>
            <tr><td><strong>Tanggal Cetak</strong></td><td>' . tanggal_indo(date('Y-m-d H:i:s')) . '</td></tr>
            <tr><td><strong>Jenis</strong></td><td>Ringkasan Perkembangan per Anak</td></tr>
        </table>

        <div class="section">A. Ringkasan Statistik</div>
        <table class="tbl">
            <tr>
                <th>Total Anak</th>
                <th>Total Penilaian</th>
                <th>Rata-rata Nilai</th>
            </tr>
            <tr>
                <td class="tc">' . $total_anak . '</td>
                <td class="tc">' . $total_penilaian . '</td>
                <td class="tc">' . number_format($rata_rata, 2) . '</td>
            </tr>
        </table>

        <div class="section">B. Ringkasan Perkembangan Per Anak</div>
        <table class="tbl">
            <tr>
                <th style="width:5%;">No</th>
                <th style="width:30%;">Nama Anak</th>
                <th style="width:16%;">Total Penilaian</th>
                <th style="width:14%;">Rata-rata Skor</th>
                <th style="width:20%;">Kategori Perkembangan</th>
                <th style="width:15%;">Update Terakhir</th>
            </tr>';

        $no = 1;
        if (!empty($summary_rows)) {
            foreach ($summary_rows as $row) {
                $tanggal_terakhir = !empty($row->tanggal_terakhir) ? tanggal_indo(date('Y-m-d', strtotime($row->tanggal_terakhir))) : '-';
                $html .= '<tr>
                    <td class="tc">' . $no++ . '</td>
                    <td>' . ($row->nama_anak ?: '-') . '</td>
                    <td class="tc">' . (int) ($row->total_penilaian ?? 0) . '</td>
                    <td class="tc">' . number_format((float) ($row->avg_score ?? 0), 2) . '</td>
                    <td>' . ($row->kategori ?: '-') . '</td>
                    <td class="tc">' . $tanggal_terakhir . '</td>
                </tr>';
            }
        } else {
            $html .= '<tr><td colspan="6" class="tc">Belum ada data ringkasan perkembangan pada periode ini.</td></tr>';
        }

        $html .= '</table>

        <div class="signature">
            <div class="right">
                <p>' . $kota . ', ' . tanggal_indo(date('Y-m-d')) . '</p>
                <p><strong>Kepala Lembaga</strong></p>
                <br><br><br>
                <p><strong><u>' . $nama_kepala . '</u></strong></p>
            </div>
        </div>';

        return $html;
    }

    public function generate_laporan_eksternal($data)
    {
        $CI =& get_instance();
        $CI->load->helper('tanggal');

        // Sort by category order: Yatim, Piatu, Yatim Piatu, Dhuafa, Fakir dan Miskin, Ibnu Sabil, Laqith
        $category_order = [
            'Yatim' => 1,
            'Piatu' => 2,
            'Yatim Piatu' => 3,
            'Dhuafa' => 4,
            'Fakir dan Miskin' => 5,
            'Ibnu Sabil' => 6,
            'Laqith' => 7
        ];

        usort($data['anak'], function ($a, $b) use ($category_order) {
            $a_order = $category_order[$a->kategori] ?? 99;
            $b_order = $category_order[$b->kategori] ?? 99;
            return $a_order <=> $b_order;
        });

        $putra = array_values(array_filter($data['anak'], function ($a) {
            return strtoupper((string) ($a->jenis_kelamin ?? '')) === 'L';
        }));
        $putri = array_values(array_filter($data['anak'], function ($a) {
            return strtoupper((string) ($a->jenis_kelamin ?? '')) === 'P';
        }));

        usort($putra, function ($a, $b) {
            return strcasecmp((string) ($a->nama_anak ?? ''), (string) ($b->nama_anak ?? ''));
        });
        usort($putri, function ($a, $b) {
            return strcasecmp((string) ($a->nama_anak ?? ''), (string) ($b->nama_anak ?? ''));
        });

        $total_anak = count($data['anak']);
        $total_putra = count($putra);
        $total_putri = count($putri);

        $status_tinggal_counts = array();
        $kategori_counts = array();
        $pendidikan_counts = array();
        $usia_total = 0;
        $usia_count = 0;

        foreach ($data['anak'] as $a) {
            $status_tinggal = trim((string) ($a->status_tinggal ?? ''));
            $status_tinggal = $status_tinggal !== '' ? $status_tinggal : '-';
            if (!isset($status_tinggal_counts[$status_tinggal])) {
                $status_tinggal_counts[$status_tinggal] = 0;
            }
            $status_tinggal_counts[$status_tinggal]++;

            $kategori = trim((string) ($a->kategori ?? ''));
            $kategori = $kategori !== '' ? $kategori : '-';
            if (!isset($kategori_counts[$kategori])) {
                $kategori_counts[$kategori] = 0;
            }
            $kategori_counts[$kategori]++;

            $pendidikan = trim((string) ($a->pendidikan ?? ''));
            $pendidikan = $pendidikan !== '' ? $pendidikan : '-';
            if (!isset($pendidikan_counts[$pendidikan])) {
                $pendidikan_counts[$pendidikan] = 0;
            }
            $pendidikan_counts[$pendidikan]++;

            if (!empty($a->tanggal_lahir)) {
                $usia_total += (int) umur($a->tanggal_lahir);
                $usia_count++;
            }
        }

        arsort($status_tinggal_counts);
        arsort($kategori_counts);
        arsort($pendidikan_counts);

        $render_distribution_table = function ($title, $label_col, $items, $base_total) {
            $table_html = '
        <h4 style="margin-top: 16px; margin-bottom: 8px;">' . $title . '</h4>
        <table border="1" cellpadding="4" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 10px; margin-bottom: 12px;">
            <thead style="background-color: #e0e0e0;">
                <tr>
                    <th style="text-align: center; width: 50%;">' . $label_col . '</th>
                    <th style="text-align: center; width: 25%;">Jumlah</th>
                    <th style="text-align: center; width: 25%;">Persentase</th>
                </tr>
            </thead>
            <tbody>';

            if (empty($items)) {
                $table_html .= '<tr><td colspan="3" style="text-align:center;">Tidak ada data.</td></tr>';
            } else {
                foreach ($items as $label => $jumlah) {
                    $persen = $base_total > 0 ? round(((float) $jumlah / (float) $base_total) * 100, 1) : 0;
                    $table_html .= '<tr>
                        <td>' . $label . '</td>
                        <td style="text-align: center;">' . $jumlah . '</td>
                        <td style="text-align: center;">' . $persen . '%</td>
                    </tr>';
                }
            }

            $table_html .= '</tbody></table>';
            return $table_html;
        };

        $rata_usia = $usia_count > 0 ? number_format($usia_total / $usia_count, 1) : '0.0';

        // Create new Mpdf instance with portrait orientation
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P', // Portrait
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 15,
            'margin_bottom' => 15,
            'margin_footer' => 5
        ]);

        $settings = $CI->config->item('settings');
        $nama_lksa = $settings->nama_lksa ?? 'LKSA Harapan Bangsa';

        $kop_html = '';
        if (!empty($settings->kop_surat)) {
            $kop_path = FCPATH . 'assets/uploads/kop/' . $settings->kop_surat;
            if (file_exists($kop_path)) {
                $kop_data = base64_encode(file_get_contents($kop_path));
                $kop_ext = pathinfo($kop_path, PATHINFO_EXTENSION);
                $mime = ($kop_ext == 'png') ? 'image/png' : 'image/jpeg';

                $kop_html = '<div style="text-align: center; margin-bottom: 10px;">
                    <img src="data:' . $mime . ';base64,' . $kop_data . '" style="max-width: 100%; height: auto;" />
                </div>';
            } else {
                $kop_html = $this->get_text_header($settings, $nama_lksa);
            }
        } else {
            $kop_html = $this->get_text_header($settings, $nama_lksa);
        }

        $html = $kop_html . '
        <h3 style="text-align: center; margin-bottom: 20px;">LAPORAN EKSTERNAL DATA ANAK</h3>
        <p style="text-align: center; margin-bottom: 20px;">Periode: ' . bulan_indo(date('n')) . ' ' . date('Y') . '</p>
        <h4 style="margin: 10px 0 8px 0;">Rekap Data</h4>
        <table border="1" cellpadding="4" cellspacing="0" style="width: 55%; border-collapse: collapse; font-size: 10px; margin-bottom: 16px;">
            <tr style="background-color: #f0f0f0;">
                <th style="text-align: left; width: 70%;">Keterangan</th>
                <th style="text-align: center; width: 30%;">Jumlah</th>
            </tr>
            <tr>
                <td>Total Anak</td>
                <td style="text-align: center;">' . $total_anak . '</td>
            </tr>
            <tr>
                <td>Total Putra</td>
                <td style="text-align: center;">' . $total_putra . '</td>
            </tr>
            <tr>
                <td>Total Putri</td>
                <td style="text-align: center;">' . $total_putri . '</td>
            </tr>
            <tr>
                <td>Rata-rata Usia</td>
                <td style="text-align: center;">' . $rata_usia . ' tahun</td>
            </tr>
        </table>';

        $html .= '
        <h4 style="margin-top: 16px; margin-bottom: 8px;">Statistik Jenis Kelamin</h4>
        <table border="1" cellpadding="4" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 10px; margin-bottom: 12px;">
            <thead style="background-color: #e0e0e0;">
                <tr>
                    <th style="text-align: center; width: 50%;">Jenis Kelamin</th>
                    <th style="text-align: center; width: 25%;">Jumlah</th>
                    <th style="text-align: center; width: 25%;">Persentase</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Putra</td>
                    <td style="text-align: center;">' . $total_putra . '</td>
                    <td style="text-align: center;">' . ($total_anak > 0 ? round(($total_putra / $total_anak) * 100, 1) : 0) . '%</td>
                </tr>
                <tr>
                    <td>Putri</td>
                    <td style="text-align: center;">' . $total_putri . '</td>
                    <td style="text-align: center;">' . ($total_anak > 0 ? round(($total_putri / $total_anak) * 100, 1) : 0) . '%</td>
                </tr>
            </tbody>
        </table>';

        $html .= $render_distribution_table('Statistik Status Tinggal', 'Status Tinggal', $status_tinggal_counts, $total_anak);
        $html .= $render_distribution_table('Statistik Kategori', 'Kategori', $kategori_counts, $total_anak);
        $html .= $render_distribution_table('Statistik Pendidikan', 'Tingkat Pendidikan', $pendidikan_counts, $total_anak);

        $render_eksternal_table = function ($title, $rows) {
            $table_html = '
        <h4 style="margin: 10px 0 8px 0;">' . $title . '</h4>
        <table border="1" cellpadding="4" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 10px; margin-bottom: 16px;">
            <thead style="background-color: #f0f0f0;">
                <tr>
                    <th style="width: 4%; text-align: center;">No</th>
                    <th style="width: 18%;">Nama Anak</th>
                    <th style="width: 6%; text-align: center;">Usia</th>
                    <th style="width: 10%; text-align: center;">Jenis Kelamin</th>
                    <th style="width: 14%;">Pendidikan</th>
                    <th style="width: 14%;">Nama Sekolah</th>
                    <th style="width: 14%;">Status Tinggal</th>
                    <th style="width: 14%;">Kategori</th>
                </tr>
            </thead>
            <tbody>';

            if (empty($rows)) {
                $table_html .= '<tr><td colspan="8" style="text-align: center;">Tidak ada data.</td></tr>';
            } else {
                $no = 1;
                foreach ($rows as $a) {
                    $table_html .= '
                <tr>
                    <td style="text-align: center;">' . $no++ . '</td>
                    <td>' . $a->nama_anak . '</td>
                    <td style="text-align: center;">' . umur($a->tanggal_lahir) . '</td>
                    <td style="text-align: center;">' . ($a->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan') . '</td>
                    <td>' . $a->pendidikan . '</td>
                    <td>' . ($a->nama_sekolah ?: '-') . '</td>
                    <td>' . ($a->status_tinggal ?: '-') . '</td>
                    <td>' . ($a->kategori ?: '-') . '</td>
                </tr>';
                }
            }

            $table_html .= '
            </tbody>
        </table>';

            return $table_html;
        };

        $html .= $render_eksternal_table('Kelompok Putra', $putra);
        $html .= $render_eksternal_table('Kelompok Putri', $putri);

        $html .= '

        <div style="margin-top: 30px; text-align: right;">
            <p>' . ($data['settings']->kota ?? '............') . ', ' . tanggal_indo(date('Y-m-d')) . '</p>
            <p style="margin-top: 50px;"><strong>' . ($data['settings']->nama_kepala ?? 'Kepala LKSA') . '</strong></p>
            <p>Kepala ' . ($data['settings']->nama_lksa ?? 'LKSA') . '</p>
        </div>';

        $mpdf->SetHTMLFooter('
        <div style="text-align: center; font-size: 9px;">
            Halaman {PAGENO} dari {nbpg} | Dicetak pada ' . tanggal_indo(date('Y-m-d H:i:s')) . '
        </div>');

        $mpdf->WriteHTML($html);
        $mpdf->Output('laporan_eksternal_' . date('Ymd') . '.pdf', 'D');
        exit;
    }
}
