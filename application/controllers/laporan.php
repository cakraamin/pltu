<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->library(array('arey','excel'));
		$this->load->helper(array('tanggal','terbilang'));
		$this->load->model('mlaporan','',TRUE);		

		if(!$this->session->userdata('logged_in')) 
		{
			redirect('home');
		}
	}

	function index()
	{
		$data = array(
			'main'			=> 'laporan',
			'laporan'		=> 'select',	
			'jenis'			=> $this->arey->getJenisLap(),
			'bulan'			=> $this->arey->getBulanLap(),
			'tahun'			=> $this->arey->getTahunLap()
		);

		$this->load->view('template',$data);
	}

	function generate()
	{
		if($this->input->post('jenis') == 1)
		{
			$this->generate_harian();
		}
		elseif($this->input->post('jenis') == 2)
		{
			$this->generate_bulanan();
		}
		elseif($this->input->post('jenis') == 3)
		{
			$this->generate_tahunan();
		}
		elseif($this->input->post('jenis') == 4)
		{
			$this->generate_custom();
		}
		elseif($this->input->post('jenis') == 5)
		{
			$this->generate_history();
		}
		else
		{
			$this->generate_klh();
		}
	}

	function generate_harian()
	{
		$kolomsss = array();
		$huruf = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','F','W','X','Y','Z');
		$abjad = array('I','II','III','IV','V');		

		/*$tanggal = $this->input->post('daily',TRUE);
		$pecah = explode("-", $tanggal);
		$tanggal = $pecah[2]." ".$this->arey->getBulanLap(intval($pecah[1]))." ".$pecah[0];

		$barang = $this->mlaporan->getBarang($this->input->post('daily',TRUE),0,1);*/

		//$tanggal = date('Y-m-d');
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(0);			
		$objWorksheet = $this->excel->getActiveSheet();
		$tgl1 = $this->input->post('lawal',TRUE);
		$tgl2 = $this->input->post('lakhir',TRUE);
		$lapMinggu = $this->mlaporan->getGraphHarian($tgl1,$tgl2);
		$jumLapMinggu = count($lapMinggu);
		$objWorksheet->fromArray($lapMinggu);
	
		//laporan fly ash 1#2
		$dataseriesLabels1 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$1', NULL, 1),	//	2010
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$1', NULL, 1),	//	2011						
		);
		
		$xAxisTickValues1 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$'.$jumLapMinggu, NULL, 4),	//	Q1 to Q4
		);
		
		$dataSeriesValues1 = array(
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$B$2:$B$'.$jumLapMinggu, NULL, 4),
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$2:$C$'.$jumLapMinggu, NULL, 4),						
		);

		$series1 = new PHPExcel_Chart_DataSeries(
			PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
			PHPExcel_Chart_DataSeries::GROUPING_STACKED,	// plotGrouping
			range(0, count($dataSeriesValues1)-1),			// plotOrder
			$dataseriesLabels1,								// plotLabel
			$xAxisTickValues1,								// plotCategory
			$dataSeriesValues1								// plotValues
		);
		
		$series1->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

		$plotarea1 = new PHPExcel_Chart_PlotArea(NULL, array($series1));
	
		$legend1 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

		$title1 = new PHPExcel_Chart_Title('WEEKLY REPORT FLY ASH 1&2');
		$yAxisLabel1 = new PHPExcel_Chart_Title('Total (Ton)');

		$chart1 = new PHPExcel_Chart(
			'chart1',		// name
			$title1,			// title
			$legend1,		// legend
			$plotarea1,		// plotArea
			true,			// plotVisibleOnly
			0,				// displayBlanksAs
			NULL,			// xAxisLabel
			$yAxisLabel1		// yAxisLabel
		);

		$chart1->setTopLeftPosition('A1');
		$chart1->setBottomRightPosition('H25');

		$objWorksheet->addChart($chart1);

		//laporan fly ash 3#4
		$dataseriesLabels2 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$1', NULL, 1),	//	2010
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$1', NULL, 1),	//	2011						
		);
		
		$xAxisTickValues2 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$'.$jumLapMinggu, NULL, 4),	//	Q1 to Q4
		);
		
		$dataSeriesValues2 = array(
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$2:$D$'.$jumLapMinggu, NULL, 4),
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$E$2:$E$'.$jumLapMinggu, NULL, 4),						
		);

		$series2 = new PHPExcel_Chart_DataSeries(
			PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
			PHPExcel_Chart_DataSeries::GROUPING_STACKED,	// plotGrouping
			range(0, count($dataSeriesValues2)-1),			// plotOrder
			$dataseriesLabels2,								// plotLabel
			$xAxisTickValues2,								// plotCategory
			$dataSeriesValues2								// plotValues
		);
		
		$series2->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

		$plotarea2 = new PHPExcel_Chart_PlotArea(NULL, array($series2));
	
		$legend2 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

		$title2 = new PHPExcel_Chart_Title('WEEKLY REPORT FLY ASH 3&4');
		$yAxisLabel2 = new PHPExcel_Chart_Title('Total (Ton)');

		$chart2 = new PHPExcel_Chart(
			'chart2',		// name
			$title2,			// title
			$legend2,		// legend
			$plotarea2,		// plotArea
			true,			// plotVisibleOnly
			0,				// displayBlanksAs
			NULL,			// xAxisLabel
			$yAxisLabel2		// yAxisLabel
		);

		$chart2->setTopLeftPosition('H1');
		$chart2->setBottomRightPosition('O25');

		$objWorksheet->addChart($chart2);

		//laporan bottom ash 1#2
		$dataseriesLabels3 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$1', NULL, 1),	//	2010
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$1', NULL, 1),	//	2011						
		);
		
		$xAxisTickValues3 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$'.$jumLapMinggu, NULL, 4),	//	Q1 to Q4
		);
		
		$dataSeriesValues3 = array(
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$F$2:$F$'.$jumLapMinggu, NULL, 4),
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$G$2:$G$'.$jumLapMinggu, NULL, 4),						
		);

		$series3 = new PHPExcel_Chart_DataSeries(
			PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
			PHPExcel_Chart_DataSeries::GROUPING_STACKED,	// plotGrouping
			range(0, count($dataSeriesValues3)-1),			// plotOrder
			$dataseriesLabels3,								// plotLabel
			$xAxisTickValues3,								// plotCategory
			$dataSeriesValues3								// plotValues
		);
		
		$series3->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

		$plotarea3 = new PHPExcel_Chart_PlotArea(NULL, array($series3));
	
		$legend3 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

		$title3 = new PHPExcel_Chart_Title('WEEKLY REPORT BOTTOM ASH 1&2');
		$yAxisLabel3 = new PHPExcel_Chart_Title('Total (Ton)');

		$chart3 = new PHPExcel_Chart(
			'chart3',		// name
			$title3,			// title
			$legend3,		// legend
			$plotarea3,		// plotArea
			true,			// plotVisibleOnly
			0,				// displayBlanksAs
			NULL,			// xAxisLabel
			$yAxisLabel3		// yAxisLabel
		);

		$chart3->setTopLeftPosition('A26');
		$chart3->setBottomRightPosition('H50');

		$objWorksheet->addChart($chart3);

		//laporan bottom ash 3#4
		$dataseriesLabels4 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$1', NULL, 1),	//	2010
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$1', NULL, 1),	//	2011						
		);
		
		$xAxisTickValues4 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$'.$jumLapMinggu, NULL, 4),	//	Q1 to Q4
		);
		
		$dataSeriesValues4 = array(
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$2:$D$'.$jumLapMinggu, NULL, 4),
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$E$2:$E$'.$jumLapMinggu, NULL, 4),						
		);

		$series4 = new PHPExcel_Chart_DataSeries(
			PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
			PHPExcel_Chart_DataSeries::GROUPING_STACKED,	// plotGrouping
			range(0, count($dataSeriesValues4)-1),			// plotOrder
			$dataseriesLabels4,								// plotLabel
			$xAxisTickValues4,								// plotCategory
			$dataSeriesValues4								// plotValues
		);
		
		$series4->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

		$plotarea4 = new PHPExcel_Chart_PlotArea(NULL, array($series4));
	
		$legend4 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

		$title4 = new PHPExcel_Chart_Title('WEEKLY REPORT BOTTOM ASH 3&4');
		$yAxisLabel4 = new PHPExcel_Chart_Title('Total (Ton)');

		$chart4 = new PHPExcel_Chart(
			'chart4',		// name
			$title4,			// title
			$legend4,		// legend
			$plotarea4,		// plotArea
			true,			// plotVisibleOnly
			0,				// displayBlanksAs
			NULL,			// xAxisLabel
			$yAxisLabel4		// yAxisLabel
		);

		$chart4->setTopLeftPosition('H26');
		$chart4->setBottomRightPosition('O50');

		$objWorksheet->addChart($chart4);

		//laporan gypsum 1#2
		$dataseriesLabels5 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$1', NULL, 1),	//	2010
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$1', NULL, 1),	//	2011						
		);
		
		$xAxisTickValues5 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$'.$jumLapMinggu, NULL, 4),	//	Q1 to Q4
		);
		
		$dataSeriesValues5 = array(
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$H$2:$H$'.$jumLapMinggu, NULL, 4),
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$I$2:$I$'.$jumLapMinggu, NULL, 4),						
		);

		$series5 = new PHPExcel_Chart_DataSeries(
			PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
			PHPExcel_Chart_DataSeries::GROUPING_STACKED,	// plotGrouping
			range(0, count($dataSeriesValues5)-1),			// plotOrder
			$dataseriesLabels5,								// plotLabel
			$xAxisTickValues5,								// plotCategory
			$dataSeriesValues5								// plotValues
		);
		
		$series5->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

		$plotarea5 = new PHPExcel_Chart_PlotArea(NULL, array($series5));
	
		$legend5 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

		$title5 = new PHPExcel_Chart_Title('WEEKLY REPORT GYPSUM 1&2');
		$yAxisLabel5 = new PHPExcel_Chart_Title('Total (Ton)');

		$chart5 = new PHPExcel_Chart(
			'chart5',		// name
			$title5,			// title
			$legend5,		// legend
			$plotarea5,		// plotArea
			true,			// plotVisibleOnly
			0,				// displayBlanksAs
			NULL,			// xAxisLabel
			$yAxisLabel5		// yAxisLabel
		);

		$chart5->setTopLeftPosition('A51');
		$chart5->setBottomRightPosition('H75');

		$objWorksheet->addChart($chart5);

		//laporan gypsum 3#4
		$dataseriesLabels6 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$1', NULL, 1),	//	2010
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$1', NULL, 1),	//	2011						
		);
		
		$xAxisTickValues6 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$'.$jumLapMinggu, NULL, 4),	//	Q1 to Q4
		);
		
		$dataSeriesValues6 = array(
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$2:$D$'.$jumLapMinggu, NULL, 4),
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$E$2:$E$'.$jumLapMinggu, NULL, 4),						
		);

		$series6 = new PHPExcel_Chart_DataSeries(
			PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
			PHPExcel_Chart_DataSeries::GROUPING_STACKED,	// plotGrouping
			range(0, count($dataSeriesValues6)-1),			// plotOrder
			$dataseriesLabels6,								// plotLabel
			$xAxisTickValues6,								// plotCategory
			$dataSeriesValues6								// plotValues
		);
		
		$series6->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

		$plotarea6 = new PHPExcel_Chart_PlotArea(NULL, array($series6));
	
		$legend6 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

		$title6 = new PHPExcel_Chart_Title('WEEKLY REPORT GYPSUM 3&4');
		$yAxisLabel6 = new PHPExcel_Chart_Title('Total (Ton)');

		$chart6 = new PHPExcel_Chart(
			'chart6',		// name
			$title6,			// title
			$legend6,		// legend
			$plotarea6,		// plotArea
			true,			// plotVisibleOnly
			0,				// displayBlanksAs
			NULL,			// xAxisLabel
			$yAxisLabel6		// yAxisLabel
		);

		$chart6->setTopLeftPosition('H51');
		$chart6->setBottomRightPosition('O75');

		$objWorksheet->addChart($chart6);

		$margin = 0.5 / 2.54;

		$this->excel->getActiveSheet()->getPageMargins()->setTop($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setBottom($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setLeft($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setRight($margin);

		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$this->excel->getActiveSheet()->getSheetView()->setView(PHPExcel_Worksheet_SheetView::SHEETVIEW_PAGE_LAYOUT);
		$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);

		$limbah = $this->arey->getLimbah();		

		$mulai = 1;
		$warna1 = array('c4d79b','f2dcdb','fcd5b4');
		$warna2 = array('dce6f1','dce6f1','d9d9d9');
		$nn = 0;
		foreach($limbah as $key => $dt_limbah)
		{
			foreach($dt_limbah as $kunci => $limbahs)	
			{
				$styleArray = array(
					'borders' => array(
				    	'allborders' => array(
				      		'style' => PHPExcel_Style_Border::BORDER_THIN
				    	)
				  	)
				);		

				$this->excel->createSheet();
				$this->excel->setActiveSheetIndex($mulai);
				$this->excel->getActiveSheet($mulai)->setTitle($key." ".$kunci);
				$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
				$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
				
				$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(9);
				$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(9);				

				$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
				$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
				$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
				$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
				$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
				$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
				$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
				$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(12);
				$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(12);
				$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(12);
				$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(10);								
				
				$objDrawing = new PHPExcel_Worksheet_Drawing();
				$objDrawing->setName('PHPExcel logo');
				$objDrawing->setDescription('PHPExcel logo');
				$objDrawing->setPath('./assets/gambar/pln.png');
				$objDrawing->setHeight(100);                
				$objDrawing->setCoordinates('A1');
				$objDrawing->setWorksheet($this->excel->getActiveSheet());

				$objDrawings = new PHPExcel_Worksheet_Drawing();
				$objDrawings->setName('PHPExcel logo');
				$objDrawings->setDescription('PHPExcel logo');
				$objDrawings->setPath('./assets/gambar/pjb.png');
				$objDrawings->setHeight(90);                
				$objDrawings->setCoordinates('L1');
				$objDrawings->setWorksheet($this->excel->getActiveSheet());
						
				$this->excel->getActiveSheet()->mergeCells('D1:J1');				
				$this->excel->getActiveSheet()->setCellValue('D1', 'DAILY REPORT');
				$this->excel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(20);
				$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);		

				$uni = explode("#", $kunci);

				$this->excel->getActiveSheet()->mergeCells('D2:J2');				
				$this->excel->getActiveSheet()->setCellValue('D2', $key." Unit ".$uni[0]." dan Unit ".$uni[1]);
				$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(15);
				$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);		

				$this->excel->getActiveSheet()->mergeCells('D3:J3');				
				$this->excel->getActiveSheet()->setCellValue('D3', "PLTU TANJUNG JATI B JEPARA");
				$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle('D3')->getFont()->setSize(15);
				$this->excel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);		

				/*$this->excel->getActiveSheet()->mergeCells('A5:N5');				
				$this->excel->getActiveSheet()->setCellValue('A5', $key."To Be Off Taking Unit ".$uni[0]."&".$uni[1]);
				$this->excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle('A5:A5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('99cc00');*/

				$this->excel->getActiveSheet()->mergeCells('A5:O5');				
				$this->excel->getActiveSheet()->setCellValue('A5', $key." Unit ".$uni[0]."&".$uni[1]);
				$this->excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle('A5:N5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($warna1[$nn]);

				$this->excel->getActiveSheet()->mergeCells('A6:A7');				
				$this->excel->getActiveSheet()->setCellValue('A6', "No");
				$this->excel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle('A6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
				$this->excel->getActiveSheet()->mergeCells('B6:B7');				
				$this->excel->getActiveSheet()->setCellValue('B6', "Date");
				$this->excel->getActiveSheet()->getStyle('B6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle('B6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
				$this->excel->getActiveSheet()->mergeCells('C6:D6');				
				$this->excel->getActiveSheet()->setCellValue('C6', "Time");
				$this->excel->getActiveSheet()->getStyle('C6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);								
				$this->excel->getActiveSheet()->setCellValue('C7', "Time In");
				$this->excel->getActiveSheet()->getStyle('C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);								
				$this->excel->getActiveSheet()->setCellValue('D7', "Time Out");
				$this->excel->getActiveSheet()->getStyle('D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
				$this->excel->getActiveSheet()->mergeCells('E6:E7');				
				$this->excel->getActiveSheet()->setCellValue('E6', "Dispatch No");
				$this->excel->getActiveSheet()->getStyle('E6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle('E6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
				$this->excel->getActiveSheet()->mergeCells('F6:F7');				
				$this->excel->getActiveSheet()->setCellValue('F6', "Manifest No");
				$this->excel->getActiveSheet()->getStyle('F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle('F6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
				$this->excel->getActiveSheet()->mergeCells('G6:G7');				
				$this->excel->getActiveSheet()->setCellValue('G6', "Material Gate \n Pass No");
				$this->excel->getActiveSheet()->getStyle('G6')->getAlignment()->setWrapText(true);
				$this->excel->getActiveSheet()->getStyle('G6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle('G6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
				$this->excel->getActiveSheet()->mergeCells('H6:H7');				
				$this->excel->getActiveSheet()->setCellValue('H6', "Police No");
				$this->excel->getActiveSheet()->getStyle('H6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle('H6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
				$this->excel->getActiveSheet()->mergeCells('I6:I7');				
				$this->excel->getActiveSheet()->setCellValue('I6', "Transporter");
				$this->excel->getActiveSheet()->getStyle('I6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle('I6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
				$this->excel->getActiveSheet()->mergeCells('J6:J7');				
				$this->excel->getActiveSheet()->setCellValue('J6', "Driver Name");
				$this->excel->getActiveSheet()->getStyle('J6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle('J6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
				$this->excel->getActiveSheet()->mergeCells('K6:K7');				
				$this->excel->getActiveSheet()->setCellValue('K6', "User");
				$this->excel->getActiveSheet()->getStyle('K6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle('K6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);		
				$this->excel->getActiveSheet()->mergeCells('L6:N6');				
				$this->excel->getActiveSheet()->setCellValue('L6', "Volume(Ton)");
				$this->excel->getActiveSheet()->getStyle('L6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$this->excel->getActiveSheet()->setCellValue('L7', "Empty");
				$this->excel->getActiveSheet()->getStyle('L7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$this->excel->getActiveSheet()->setCellValue('M7', "Gross");
				$this->excel->getActiveSheet()->getStyle('M7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$this->excel->getActiveSheet()->setCellValue('N7', "Nett");
				$this->excel->getActiveSheet()->getStyle('N7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$this->excel->getActiveSheet()->mergeCells('O6:O7');				
				$this->excel->getActiveSheet()->setCellValue('O6', "Remaks");
				$this->excel->getActiveSheet()->getStyle('O6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle('O6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
				$this->excel->getActiveSheet()->getStyle('A6:O7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($warna2[$nn]);

				$this->excel->getActiveSheet()->setCellValue('A8', "1");
				$this->excel->getActiveSheet()->getStyle('A8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
				$this->excel->getActiveSheet()->setCellValue('B8', "2");
				$this->excel->getActiveSheet()->getStyle('B8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);									
				$this->excel->getActiveSheet()->setCellValue('C8', "3");
				$this->excel->getActiveSheet()->getStyle('C8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);									
				$this->excel->getActiveSheet()->setCellValue('D8', "4");
				$this->excel->getActiveSheet()->getStyle('D8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);						
				$this->excel->getActiveSheet()->setCellValue('E8', "5");
				$this->excel->getActiveSheet()->getStyle('E8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);									
				$this->excel->getActiveSheet()->setCellValue('F8', "6");				
				$this->excel->getActiveSheet()->getStyle('F8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);										
				$this->excel->getActiveSheet()->setCellValue('G8', "7");
				$this->excel->getActiveSheet()->getStyle('G8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);										
				$this->excel->getActiveSheet()->setCellValue('H8', "8");
				$this->excel->getActiveSheet()->getStyle('H8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);										
				$this->excel->getActiveSheet()->setCellValue('I8', "9");
				$this->excel->getActiveSheet()->getStyle('I8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);								
				$this->excel->getActiveSheet()->setCellValue('J8', "10");
				$this->excel->getActiveSheet()->getStyle('J8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);										
				$this->excel->getActiveSheet()->setCellValue('K8', "11");
				$this->excel->getActiveSheet()->getStyle('K8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$this->excel->getActiveSheet()->setCellValue('L8', "12");
				$this->excel->getActiveSheet()->getStyle('L8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$this->excel->getActiveSheet()->setCellValue('M8', "13");
				$this->excel->getActiveSheet()->getStyle('M8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);						
				$this->excel->getActiveSheet()->setCellValue('N8', "14");
				$this->excel->getActiveSheet()->getStyle('N8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
				$this->excel->getActiveSheet()->setCellValue('O8', "15");
				$this->excel->getActiveSheet()->getStyle('O8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
				
				$this->excel->getActiveSheet()->getStyle('A8:O8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00');

				$baris = 9;		
				$no = 1;		
				$awal = $this->input->post('lawal',TRUE);
				$akhir = $this->input->post('lakhir',TRUE);
				$lawal = strtotime($awal);
				$lakhir = strtotime($akhir);				
				for($o=$lawal;$o<=$lakhir;$o+=86400)
				{					
					$tanggalt = date('Y-m-d', $o);										
					$sold = $this->mlaporan->getHarianSold($tanggalt,$limbahs,1);					

					foreach($sold as $dt_sold)
					{						
						$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);			
						$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
						$this->excel->getActiveSheet()->setCellValue('B'.$baris, $this->tanggals($tanggalt));
						$this->excel->getActiveSheet()->setCellValue('C'.$baris, $dt_sold['jamtb1']);
						$this->excel->getActiveSheet()->setCellValue('D'.$baris, $dt_sold['jamtb2']);

						$do = isset($dt_sold['nomorspk'])?$dt_sold['nomorspk']:"//";
				        $pecahdo = explode("/", $do);
				        $jalan = (isset($pecahdo[0]) && $pecahdo[0] != "")?$pecahdo[0]:"";
				        $manifest = (isset($pecahdo[1]) && $pecahdo[1] != "")?$pecahdo[1]:"";
				        $mgp = (isset($pecahdo[2]) && $pecahdo[2] != "")?$pecahdo[2]:"";

				        $this->excel->getActiveSheet()->setCellValue('E'.$baris, $jalan);
				        $this->excel->getActiveSheet()->setCellValue('F'.$baris, $manifest);
				        $this->excel->getActiveSheet()->setCellValue('G'.$baris, $mgp);
				        $this->excel->getActiveSheet()->setCellValue('H'.$baris, $dt_sold['nopol']);
				        $this->excel->getActiveSheet()->setCellValue('I'.$baris, $dt_sold['namatrsp']);
				        $this->excel->getActiveSheet()->setCellValue('J'.$baris, $dt_sold['sopir']);
				        $this->excel->getActiveSheet()->setCellValue('K'.$baris, $dt_sold['namacust']);
				        $this->excel->getActiveSheet()->setCellValue('L'.$baris, $dt_sold['timbang1']);
				        $this->excel->getActiveSheet()->getStyle('L'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
				        $this->excel->getActiveSheet()->setCellValue('M'.$baris, $dt_sold['timbang2']);
				        $this->excel->getActiveSheet()->getStyle('M'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
				        $this->excel->getActiveSheet()->setCellValue('N'.$baris, $dt_sold['netto']);
				        $this->excel->getActiveSheet()->getStyle('N'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
				        $this->excel->getActiveSheet()->setCellValue('O'.$baris, "-");
				        $this->excel->getActiveSheet()->getStyle('O'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						$baris++;	
						$no++;		
					}					
				}				

				$this->excel->getActiveSheet()->freezePane('A9');

				$this->excel->getActiveSheet()->getStyle('A5:O'.$baris)->applyFromArray($styleArray);
				unset($styleArray);
			
				$awalst = $baris+2;
				$baris1 = $awalst+1;
				$baris2 = $awalst+2;
				$baris3 = $awalst+3;
				if($key != 'GYPSUM')
				{				
					$styleArray = array(
						'borders' => array(
					    	'allborders' => array(
					      		'style' => PHPExcel_Style_Border::BORDER_THIN
					    	)
					  	)
					);	

					$this->excel->getActiveSheet()->mergeCells('A'.$awalst.':I'.$awalst);
					$this->excel->getActiveSheet()->setCellValue('A'.$awalst, $key." To Ash Yard Unit ".$uni[0]."&".$uni[1]);
					$this->excel->getActiveSheet()->getStyle('A'.$awalst)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);										
					$this->excel->getActiveSheet()->getStyle('A'.$awalst.':I'.$awalst)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($warna1[$nn]);

					$this->excel->getActiveSheet()->mergeCells('A'.$baris1.':A'.$baris2);
					$this->excel->getActiveSheet()->setCellValue('A'.$baris1, "No");
					$this->excel->getActiveSheet()->getStyle('A'.$baris1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excel->getActiveSheet()->getStyle('A'.$baris1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
					$this->excel->getActiveSheet()->mergeCells('B'.$baris1.':B'.$baris2);
					$this->excel->getActiveSheet()->setCellValue('B'.$baris1, "Date");
					$this->excel->getActiveSheet()->getStyle('B'.$baris1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excel->getActiveSheet()->getStyle('B'.$baris1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
					$this->excel->getActiveSheet()->mergeCells('C'.$baris1.':C'.$baris2);				
					$this->excel->getActiveSheet()->setCellValue('C'.$baris1, "Time Out");
					$this->excel->getActiveSheet()->getStyle('C'.$baris1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excel->getActiveSheet()->getStyle('C'.$baris1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
					$this->excel->getActiveSheet()->mergeCells('D'.$baris1.':D'.$baris2);				
					$this->excel->getActiveSheet()->setCellValue('D'.$baris1, "Time In");
					$this->excel->getActiveSheet()->getStyle('D'.$baris1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excel->getActiveSheet()->getStyle('D'.$baris1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				

					$this->excel->getActiveSheet()->mergeCells('E'.$baris1.':E'.$baris2);				
					$this->excel->getActiveSheet()->setCellValue('E'.$baris1, "Type \n Equipment");
					$this->excel->getActiveSheet()->getStyle('E'.$baris1)->getAlignment()->setWrapText(true);
					$this->excel->getActiveSheet()->getStyle('E'.$baris1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excel->getActiveSheet()->getStyle('E'.$baris1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
					$this->excel->getActiveSheet()->mergeCells('F'.$baris1.':F'.$baris2);
					$this->excel->getActiveSheet()->setCellValue('F'.$baris1, "Operator \n Name");
					$this->excel->getActiveSheet()->getStyle('F'.$baris1)->getAlignment()->setWrapText(true);
					$this->excel->getActiveSheet()->getStyle('F'.$baris1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excel->getActiveSheet()->getStyle('F'.$baris1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);									
					$this->excel->getActiveSheet()->mergeCells('G'.$baris1.':I'.$baris1);
					$this->excel->getActiveSheet()->setCellValue('G'.$baris1, "Volume (Ton)");					
					$this->excel->getActiveSheet()->getStyle('G'.$baris1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);					
					$this->excel->getActiveSheet()->setCellValue('G'.$baris2, "Empty");					
					$this->excel->getActiveSheet()->getStyle('G'.$baris2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);					
					$this->excel->getActiveSheet()->setCellValue('H'.$baris2, "Gross");
					$this->excel->getActiveSheet()->getStyle('H'.$baris2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);												
					$this->excel->getActiveSheet()->setCellValue('I'.$baris2, "Netto");
					$this->excel->getActiveSheet()->getStyle('I'.$baris2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);					
					$this->excel->getActiveSheet()->getStyle('A'.$baris1.':I'.$baris2)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($warna2[$nn]);

					$this->excel->getActiveSheet()->setCellValue('A'.$baris3, "1");
					$this->excel->getActiveSheet()->getStyle('A'.$baris3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
					$this->excel->getActiveSheet()->setCellValue('B'.$baris3, "2");
					$this->excel->getActiveSheet()->getStyle('B'.$baris3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);									
					$this->excel->getActiveSheet()->setCellValue('C'.$baris3, "3");
					$this->excel->getActiveSheet()->getStyle('C'.$baris3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);									
					$this->excel->getActiveSheet()->setCellValue('D'.$baris3, "4");
					$this->excel->getActiveSheet()->getStyle('D'.$baris3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);						
					$this->excel->getActiveSheet()->setCellValue('E'.$baris3, "5");
					$this->excel->getActiveSheet()->getStyle('E'.$baris3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);									
					$this->excel->getActiveSheet()->setCellValue('F'.$baris3, "6");				
					$this->excel->getActiveSheet()->getStyle('F'.$baris3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);										
					$this->excel->getActiveSheet()->setCellValue('G'.$baris3, "7");
					$this->excel->getActiveSheet()->getStyle('G'.$baris3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);										
					$this->excel->getActiveSheet()->setCellValue('H'.$baris3, "8");
					$this->excel->getActiveSheet()->getStyle('H'.$baris3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);															
					$this->excel->getActiveSheet()->setCellValue('I'.$baris3, "9");
					$this->excel->getActiveSheet()->getStyle('I'.$baris3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);															
					$this->excel->getActiveSheet()->getStyle('A'.$baris3.':I'.$baris3)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00');					

					$baris = $awalst+4;		
					$no = 1;		
					$awal = $this->input->post('lawal',TRUE);
					$akhir = $this->input->post('lakhir',TRUE);
					$lawal = strtotime($awal);
					$lakhir = strtotime($akhir);				
					for($o=$lawal;$o<=$lakhir;$o+=86400)
					{					
						$tanggalt = date('Y-m-d', $o);										
						$sold = $this->mlaporan->getHarianSold($tanggalt,$limbahs,2);

						foreach($sold as $dt_sold)
						{						
							$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);			
							$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
							$this->excel->getActiveSheet()->setCellValue('B'.$baris, $this->tanggals($tanggalt));
							$this->excel->getActiveSheet()->setCellValue('C'.$baris, $dt_sold['jamtb1']);							
					        $this->excel->getActiveSheet()->setCellValue('D'.$baris, $dt_sold['nopol']);
					        $this->excel->getActiveSheet()->setCellValue('E'.$baris, $dt_sold['namacust']);
					        $this->excel->getActiveSheet()->setCellValue('F'.$baris, $dt_sold['timbang1']);
					        $this->excel->getActiveSheet()->getStyle('F'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
					        $this->excel->getActiveSheet()->setCellValue('G'.$baris, $dt_sold['timbang2']);
					        $this->excel->getActiveSheet()->getStyle('G'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
					        $this->excel->getActiveSheet()->setCellValue('H'.$baris, $dt_sold['netto']);
					        $this->excel->getActiveSheet()->getStyle('H'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);						        

							$baris++;	
							$no++;		
						}					
					}
					$this->excel->getActiveSheet()->getStyle('A'.$awalst.':I'.$baris)->applyFromArray($styleArray);
					unset($styleArray);
				}				

				$margin = 0.5 / 2.54;

				$this->excel->getActiveSheet()->getPageMargins()->setTop($margin);
				$this->excel->getActiveSheet()->getPageMargins()->setBottom($margin);
				$this->excel->getActiveSheet()->getPageMargins()->setLeft($margin);
				$this->excel->getActiveSheet()->getPageMargins()->setRight($margin);

				$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
				$this->excel->getActiveSheet()->getSheetView()->setView(PHPExcel_Worksheet_SheetView::SHEETVIEW_PAGE_LAYOUT);
				$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
				$mulai++;				
			}
			$nn++;
		}		

		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename='Daily_report_'.date('Y-m-d').'.xlsx';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
	}

	function generate_history()
	{
		$kolomsss = array();
		$huruf = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','F','W','X','Y','Z');
		$abjad = array('I','II','III','IV','V');

		//$tanggal = $this->input->post('daily',TRUE);
		//$pecah = explode("-", $tanggal);
		//$tanggal = $pecah[2]." ".$this->arey->getBulanLap(intval($pecah[1]))." ".$pecah[0];
		$tanggal = $this->arey->getBulanLap($this->input->post('bulan',TRUE))." TAHUN ".$this->input->post('thn',TRUE);
		$bulanss = $this->arey->getBulanLap($this->input->post('bulan',TRUE));	

		$margin = 0.5 / 2.54;

		$this->excel->getActiveSheet()->getPageMargins()->setTop($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setBottom($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setLeft($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setRight($margin);

		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$this->excel->getActiveSheet()->getSheetView()->setView(PHPExcel_Worksheet_SheetView::SHEETVIEW_PAGE_LAYOUT);
		$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);	

		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet(1)->setTitle("Annual");
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(10);						
				
		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('PHPExcel logo');
		$objDrawing->setDescription('PHPExcel logo');
		$objDrawing->setPath('./assets/gambar/pln.png');
		$objDrawing->setHeight(100);                
		$objDrawing->setCoordinates('A1');
		$objDrawing->setWorksheet($this->excel->getActiveSheet());

		$objDrawings = new PHPExcel_Worksheet_Drawing();
		$objDrawings->setName('PHPExcel logo');
		$objDrawings->setDescription('PHPExcel logo');
		$objDrawings->setPath('./assets/gambar/pjb.png');
		$objDrawings->setHeight(90);                
		$objDrawings->setCoordinates('L1');
		$objDrawings->setWorksheet($this->excel->getActiveSheet());
						
		$this->excel->getActiveSheet()->mergeCells('D1:K1');				
		$this->excel->getActiveSheet()->setCellValue('D1', 'ANNUAL REPORT');
		$this->excel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);				

		$this->excel->getActiveSheet()->mergeCells('D2:K2');				
		$this->excel->getActiveSheet()->setCellValue('D2', "FLY ASH, BOTTOM ASH, GYPSUM");
		$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);		
		
		$this->excel->getActiveSheet()->mergeCells('D3:K3');				
		$this->excel->getActiveSheet()->setCellValue('D3', "PLTU TANJUNG JATI B JEPARA");
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D3')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);				

		$this->excel->getActiveSheet()->mergeCells('A6:A8');		
		$this->excel->getActiveSheet()->setCellValue('A6', 'NO');
		$this->excel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B6:B8');		
		$this->excel->getActiveSheet()->setCellValue('B6', 'YEAR');
		$this->excel->getActiveSheet()->getStyle('B6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);		
		$this->excel->getActiveSheet()->getStyle('A6:N7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('99cc00');
		$jns = array('ASH YARD','OFF TAKING');
		$warna = array('b8cce4','fabf8f');
		$nn = 0;
		$kolom = 2;
		$bawah = 2;
		foreach($jns as $jenis_out)
		{			
			$sampah = $this->arey->getLimbah();
			$jum_sampah = count($sampah);
			$jum_sampah = $jum_sampah*2;
			$awale = $huruf[$kolom];
			$akhire = $huruf[$kolom+$jum_sampah-1];
			$this->excel->getActiveSheet()->mergeCells($awale.'6:'.$akhire.'6');		
			$this->excel->getActiveSheet()->setCellValue($awale.'6', $jenis_out);
			$this->excel->getActiveSheet()->getStyle($awale.'6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle($awale.'6:'.$awale.'6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($warna[$nn]);
			foreach($sampah as $key => $dt_sampah)
			{
				$nkolom = $huruf[$bawah];
				$nkolom1 = $huruf[$bawah+1];
				$this->excel->getActiveSheet()->mergeCells($nkolom.'7:'.$nkolom1.'7');		
				$this->excel->getActiveSheet()->setCellValue($nkolom.'7', $key);
				$this->excel->getActiveSheet()->getStyle($nkolom.'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue($nkolom.'8', '1&2');
				$this->excel->getActiveSheet()->getStyle($nkolom.'8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle($nkolom.'8:'.$nkolom.'8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ccc0da');
				$this->excel->getActiveSheet()->setCellValue($nkolom1.'8', '3&4');
				$this->excel->getActiveSheet()->getStyle($nkolom1.'8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle($nkolom1.'8:'.$nkolom1.'8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('93cddd');
				$bawah+=2;
			}
			$kolom+=$jum_sampah;
			$nn++;
		}	

		$baris = 9;
		$no = 1;

		$tahun = $this->mlaporan->getTahunAll();
		$thns = $this->input->post('thn',TRUE);
		foreach($tahun as $dt_tahun)
		{
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_tahun->tahun);
			$kolom = 2;
			foreach($jns as $jenis_out)
			{			
				$sampah = $this->arey->getLimbah();
				foreach($sampah as $key => $dt_sampah)
				{					
					$satu = $this->mlaporan->getDataTahun($dt_tahun->tahun,$dt_sampah['1#2'],$jenis_out);
					$dua = $this->mlaporan->getDataTahun($dt_tahun->tahun,$dt_sampah['3#4'],$jenis_out);
					$nkolom = $huruf[$kolom];
					$nkolom1 = $huruf[$kolom+1];
					$this->excel->getActiveSheet()->setCellValue($nkolom.$baris, $satu);
					$this->excel->getActiveSheet()->getStyle($nkolom.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);					
					$this->excel->getActiveSheet()->setCellValue($nkolom1.$baris, $dua);
					$this->excel->getActiveSheet()->getStyle($nkolom1.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$kolom+=2;
				}
			}
			$baris++;
			$no++;
		}
		$this->excel->getActiveSheet()->mergeCells('A'.$baris.':B'.$baris);				
		$this->excel->getActiveSheet()->setCellValue("A".$baris, "Total (Ton)");
		$akhir = $baris-1;
		$this->excel->getActiveSheet()->setCellValue("C".$baris, "=SUM(C8:C".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("C".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("D".$baris, "=SUM(D8:D".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("D".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("E".$baris, "=SUM(E8:E".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("E".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("F".$baris, "=SUM(F8:F".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("F".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("G".$baris, "=SUM(G8:G".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("G".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("H".$baris, "=SUM(H8:H".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("H".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("I".$baris, "=SUM(I8:I".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("I".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("J".$baris, "=SUM(J8:J".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("J".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("K".$baris, "=SUM(K8:K".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("K".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("L".$baris, "=SUM(L8:L".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("L".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("M".$baris, "=SUM(M8:M".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("M".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("N".$baris, "=SUM(N8:N".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("N".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->getStyle('A'.$baris.':N'.$baris)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00');

		$this->excel->getActiveSheet()->freezePane('A9');				
		$this->excel->getActiveSheet()->getStyle('A6:N'.$baris)->applyFromArray($styleArray);		
		unset($styleArray);	

		$margin = 0.5 / 2.54;

		$this->excel->getActiveSheet()->getPageMargins()->setTop($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setBottom($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setLeft($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setRight($margin);

		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$this->excel->getActiveSheet()->getSheetView()->setView(PHPExcel_Worksheet_SheetView::SHEETVIEW_PAGE_LAYOUT);
		$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);

		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename='monthly_history_report_'.$bulanss.'_'.date('Y-m-d').'.xlsx';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
	}

	function setTgl($id)
	{
		$tgl = (strlen($id) == 1)?"0".$id:$id;

		return $tgl;
	}

	function generate_bulanan()
	{
		$kolomsss = array();
		$huruf = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','F','W','X','Y','Z');
		$abjad = array('I','II','III','IV','V');

		$kbulan = $this->input->post('bulan',TRUE);
		$bulan = $this->arey->getBulanLap($kbulan);
		$tahun = $this->input->post('thn',TRUE);

		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(0);		
		$objWorksheet = $this->excel->getActiveSheet();
		$lapBulan = $this->mlaporan->getGraphBulananan($kbulan,$tahun);
		$jumLapBulan = count($lapBulan);
		$objWorksheet->fromArray($lapBulan);
	
		//laporan fly ash
		$dataseriesLabels1 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$1', NULL, 1),	//	2010
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$1', NULL, 1),	//	2011			
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$D$1', NULL, 1),	//	2011			
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$E$1', NULL, 1),	//	2011			
		);
		
		$xAxisTickValues1 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$'.$jumLapBulan, NULL, 4),	//	Q1 to Q4
		);
		
		$dataSeriesValues1 = array(
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$B$2:$B$'.$jumLapBulan, NULL, 4),
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$2:$C$'.$jumLapBulan, NULL, 4),			
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$2:$D$'.$jumLapBulan, NULL, 4),			
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$E$2:$E$'.$jumLapBulan, NULL, 4),			
		);

		$series1 = new PHPExcel_Chart_DataSeries(
			PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
			PHPExcel_Chart_DataSeries::GROUPING_STACKED,	// plotGrouping
			range(0, count($dataSeriesValues1)-1),			// plotOrder
			$dataseriesLabels1,								// plotLabel
			$xAxisTickValues1,								// plotCategory
			$dataSeriesValues1								// plotValues
		);
		
		$series1->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

		$plotarea1 = new PHPExcel_Chart_PlotArea(NULL, array($series1));
	
		$legend1 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

		$title1 = new PHPExcel_Chart_Title('MONTHLY REPORT '.$tahun);
		$yAxisLabel1 = new PHPExcel_Chart_Title('Total (Ton)');

		$chart1 = new PHPExcel_Chart(
			'chart1',		// name
			$title1,			// title
			$legend1,		// legend
			$plotarea1,		// plotArea
			true,			// plotVisibleOnly
			0,				// displayBlanksAs
			NULL,			// xAxisLabel
			$yAxisLabel1		// yAxisLabel
		);

		$chart1->setTopLeftPosition('A1');
		$chart1->setBottomRightPosition('H25');

		$objWorksheet->addChart($chart1);

		$margin = 0.5 / 2.54;

		$this->excel->getActiveSheet()->getPageMargins()->setTop($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setBottom($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setLeft($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setRight($margin);

		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$this->excel->getActiveSheet()->getSheetView()->setView(PHPExcel_Worksheet_SheetView::SHEETVIEW_PAGE_LAYOUT);
		$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);

		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(1);
		$this->excel->getActiveSheet(1)->setTitle("Mounthly Report");
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(10);				
		$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(10);				
				
		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('PHPExcel logo');
		$objDrawing->setDescription('PHPExcel logo');
		$objDrawing->setPath('./assets/gambar/pln.png');
		$objDrawing->setHeight(100);                
		$objDrawing->setCoordinates('A1');
		$objDrawing->setWorksheet($this->excel->getActiveSheet());

		$objDrawings = new PHPExcel_Worksheet_Drawing();
		$objDrawings->setName('PHPExcel logo');
		$objDrawings->setDescription('PHPExcel logo');
		$objDrawings->setPath('./assets/gambar/pjb.png');
		$objDrawings->setHeight(90);                
		$objDrawings->setCoordinates('L1');
		$objDrawings->setWorksheet($this->excel->getActiveSheet());
						
		$this->excel->getActiveSheet()->mergeCells('D1:K1');				
		$this->excel->getActiveSheet()->setCellValue('D1', 'MONTHLY REPORT');
		$this->excel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);				

		$this->excel->getActiveSheet()->mergeCells('D2:K2');				
		$this->excel->getActiveSheet()->setCellValue('D2', "FLY ASH, BOTTOM ASH, GYPSUM");
		$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);		

		$this->excel->getActiveSheet()->mergeCells('D3:K3');				
		$this->excel->getActiveSheet()->setCellValue('D3', "MONTH ".$bulan);
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D3')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);				

		$this->excel->getActiveSheet()->mergeCells('D4:K4');				
		$this->excel->getActiveSheet()->setCellValue('D4', "PLTU TANJUNG JATI B JEPARA");
		$this->excel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D4')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true);				

		$this->excel->getActiveSheet()->mergeCells('A6:A8');		
		$this->excel->getActiveSheet()->setCellValue('A6', 'NO');
		$this->excel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B6:B8');		
		$this->excel->getActiveSheet()->setCellValue('B6', 'DATE');
		$this->excel->getActiveSheet()->getStyle('B6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);		
		$this->excel->getActiveSheet()->getStyle('A6:N7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('99cc00');
		$jns = array('ASH YARD','OFF TAKING');
		$warna = array('b8cce4','fabf8f');
		$nn = 0;
		$kolom = 2;
		$bawah = 2;
		foreach($jns as $jenis_out)
		{			
			$sampah = $this->arey->getLimbah();
			$jum_sampah = count($sampah);
			$jum_sampah = $jum_sampah*2;
			$awale = $huruf[$kolom];
			$akhire = $huruf[$kolom+$jum_sampah-1];
			$this->excel->getActiveSheet()->mergeCells($awale.'6:'.$akhire.'6');		
			$this->excel->getActiveSheet()->setCellValue($awale.'6', $jenis_out);
			$this->excel->getActiveSheet()->getStyle($awale.'6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle($awale.'6:'.$awale.'6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($warna[$nn]);
			foreach($sampah as $key => $dt_sampah)
			{
				$nkolom = $huruf[$bawah];
				$nkolom1 = $huruf[$bawah+1];
				$this->excel->getActiveSheet()->mergeCells($nkolom.'7:'.$nkolom1.'7');		
				$this->excel->getActiveSheet()->setCellValue($nkolom.'7', $key);
				$this->excel->getActiveSheet()->getStyle($nkolom.'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue($nkolom.'8', '1&2');
				$this->excel->getActiveSheet()->getStyle($nkolom.'8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle($nkolom.'8:'.$nkolom.'8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ccc0da');
				$this->excel->getActiveSheet()->setCellValue($nkolom1.'8', '3&4');
				$this->excel->getActiveSheet()->getStyle($nkolom1.'8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle($nkolom1.'8:'.$nkolom1.'8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('93cddd');
				$bawah+=2;
			}
			$kolom+=$jum_sampah;
			$nn++;
		}

		$jumlah = array('31','29','31','30','31','30','31','31','30','31','30','31');		
		$bulan = $this->input->post('bulan',TRUE);
		$buln = $this->arey->getBulanLap($bulan);
		$tahun = $this->input->post('thn',TRUE);

		$baris = 9;
		$no=1;
		$jml = $jumlah[$bulan-1];
		for($o=1;$o<=$jml;$o++)
		{
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);			
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('B'.$baris, $o." ".$buln." ".$tahun);
			$kolom = 2;
			foreach($jns as $jenis_out)
			{			
				$sampah = $this->arey->getLimbah();
				foreach($sampah as $key => $dt_sampah)
				{
					$tgl = $tahun."-".$this->setTgl($bulan)."-".$this->setTgl($o);

					$satu = $this->mlaporan->getDetailHarian($tgl,$dt_sampah['1#2'],$jenis_out);
					$dua = $this->mlaporan->getDetailHarian($tgl,$dt_sampah['3#4'],$jenis_out);
					$nkolom = $huruf[$kolom];
					$nkolom1 = $huruf[$kolom+1];
					$this->excel->getActiveSheet()->setCellValue($nkolom.$baris, $satu);
					$this->excel->getActiveSheet()->getStyle($nkolom.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
					$this->excel->getActiveSheet()->setCellValue($nkolom1.$baris, $dua);
					$this->excel->getActiveSheet()->getStyle($nkolom1.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
					$kolom+=2;
				}
			}
			$no++;
			$baris++;
		}
		$this->excel->getActiveSheet()->mergeCells('A'.$baris.':C'.$baris);				
		$this->excel->getActiveSheet()->setCellValue("A".$baris, "Total (Ton)");
		$akhir = $baris-1;
		$this->excel->getActiveSheet()->setCellValue("C".$baris, "=SUM(D8:D".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("C".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("D".$baris, "=SUM(E8:E".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("D".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("E".$baris, "=SUM(F8:F".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("E".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("F".$baris, "=SUM(G8:G".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("F".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("G".$baris, "=SUM(H8:H".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("G".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("H".$baris, "=SUM(I8:I".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("H".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("I".$baris, "=SUM(J8:J".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("I".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("J".$baris, "=SUM(K8:K".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("J".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("K".$baris, "=SUM(L8:L".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("K".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("L".$baris, "=SUM(M8:M".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("L".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("M".$baris, "=SUM(N8:N".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("M".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("N".$baris, "=SUM(O8:O".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("N".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->getStyle('A'.$baris.':N'.$baris)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00');
		$this->excel->getActiveSheet()->freezePane('A9');

		$this->excel->getActiveSheet()->getStyle('A6:N'.$baris)->applyFromArray($styleArray);		
		unset($styleArray);

		$margin = 0.5 / 2.54;

		$this->excel->getActiveSheet()->getPageMargins()->setTop($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setBottom($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setLeft($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setRight($margin);

		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$this->excel->getActiveSheet()->getSheetView()->setView(PHPExcel_Worksheet_SheetView::SHEETVIEW_PAGE_LAYOUT);
		$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);

		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename='monthly_report_'.date('Y-m-d').'.xlsx';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
	}

	function generate_tahunan()
	{
		$kolomsss = array();
		$huruf = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','F','W','X','Y','Z');
		$abjad = array('I','II','III','IV','V');

		$tahun = $this->input->post('tahun',TRUE);

		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(0);			
		$objWorksheet = $this->excel->getActiveSheet();
		$lapTahun = $this->mlaporan->getGraphTahunan($tahun);
		$jumLapTahun = count($lapTahun);
		$objWorksheet->fromArray($lapTahun);

		//laporan fly ash
		$dataseriesLabels1 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$1', NULL, 1),	//	2010
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$1', NULL, 1),	//	2011			
		);
		
		$xAxisTickValues1 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$'.$jumLapTahun, NULL, 4),	//	Q1 to Q4
		);
		
		$dataSeriesValues1 = array(
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$B$2:$B$'.$jumLapTahun, NULL, 4),
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$2:$C$'.$jumLapTahun, NULL, 4),			
		);

		$series1 = new PHPExcel_Chart_DataSeries(
			PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
			PHPExcel_Chart_DataSeries::GROUPING_STACKED,	// plotGrouping
			range(0, count($dataSeriesValues1)-1),			// plotOrder
			$dataseriesLabels1,								// plotLabel
			$xAxisTickValues1,								// plotCategory
			$dataSeriesValues1								// plotValues
		);
		
		$series1->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

		$plotarea1 = new PHPExcel_Chart_PlotArea(NULL, array($series1));
	
		$legend1 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

		$title1 = new PHPExcel_Chart_Title('ANNUAL REPORT '.$tahun.' FLY ASH');
		$yAxisLabel1 = new PHPExcel_Chart_Title('Total (Ton)');

		$chart1 = new PHPExcel_Chart(
			'chart1',		// name
			$title1,			// title
			$legend1,		// legend
			$plotarea1,		// plotArea
			true,			// plotVisibleOnly
			0,				// displayBlanksAs
			NULL,			// xAxisLabel
			$yAxisLabel1		// yAxisLabel
		);

		$chart1->setTopLeftPosition('A1');
		$chart1->setBottomRightPosition('H25');

		$objWorksheet->addChart($chart1);


		//laporan bottom ash
		$dataseriesLabels2 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$1', NULL, 1),	//	2010
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$1', NULL, 1),	//	2011			
		);
		
		$xAxisTickValues2 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$'.$jumLapTahun, NULL, 4),	//	Q1 to Q4
		);
		
		$dataSeriesValues2 = array(
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$2:$D$'.$jumLapTahun, NULL, 4),
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$E$2:$E$'.$jumLapTahun, NULL, 4),			
		);

		$series2 = new PHPExcel_Chart_DataSeries(
			PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
			PHPExcel_Chart_DataSeries::GROUPING_STACKED,	// plotGrouping
			range(0, count($dataSeriesValues2)-1),			// plotOrder
			$dataseriesLabels2,								// plotLabel
			$xAxisTickValues2,								// plotCategory
			$dataSeriesValues2								// plotValues
		);
		
		$series2->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

		$plotarea2 = new PHPExcel_Chart_PlotArea(NULL, array($series2));
	
		$legend2 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

		$title2 = new PHPExcel_Chart_Title('ANNUAL REPORT '.$tahun.' BOTTOM ASH');
		$yAxisLabel2 = new PHPExcel_Chart_Title('Total (Ton)');

		$chart2 = new PHPExcel_Chart(
			'chart2',		// name
			$title2,			// title
			$legend2,		// legend
			$plotarea2,		// plotArea
			true,			// plotVisibleOnly
			0,				// displayBlanksAs
			NULL,			// xAxisLabel
			$yAxisLabel2		// yAxisLabel
		);

		$chart2->setTopLeftPosition('H1');
		$chart2->setBottomRightPosition('O25');

		$objWorksheet->addChart($chart2);

		//laporan gypsum
		$dataseriesLabels3 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$D$1', NULL, 1),	//	2010
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$E$1', NULL, 1),	//	2011			
		);
		
		$xAxisTickValues3 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$'.$jumLapTahun, NULL, 4),	//	Q1 to Q4
		);
		
		$dataSeriesValues3 = array(
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$F$2:$F$'.$jumLapTahun, NULL, 4),
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$G$2:$G$'.$jumLapTahun, NULL, 4),			
		);

		$series3 = new PHPExcel_Chart_DataSeries(
			PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
			PHPExcel_Chart_DataSeries::GROUPING_STACKED,	// plotGrouping
			range(0, count($dataSeriesValues3)-1),			// plotOrder
			$dataseriesLabels3,								// plotLabel
			$xAxisTickValues3,								// plotCategory
			$dataSeriesValues3								// plotValues
		);
		
		$series3->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

		$plotarea3 = new PHPExcel_Chart_PlotArea(NULL, array($series3));
	
		$legend3 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

		$title3 = new PHPExcel_Chart_Title('ANNUAL REPORT '.$tahun.' GYPSUM');
		$yAxisLabel3 = new PHPExcel_Chart_Title('Total (Ton)');

		$chart3 = new PHPExcel_Chart(
			'chart3',		// name
			$title3,			// title
			$legend3,		// legend
			$plotarea3,		// plotArea
			true,			// plotVisibleOnly
			0,				// displayBlanksAs
			NULL,			// xAxisLabel
			$yAxisLabel3		// yAxisLabel
		);

		$chart3->setTopLeftPosition('A26');
		$chart3->setBottomRightPosition('H50');

		$objWorksheet->addChart($chart3);

		$margin = 0.5 / 2.54;

		$this->excel->getActiveSheet()->getPageMargins()->setTop($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setBottom($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setLeft($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setRight($margin);

		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$this->excel->getActiveSheet()->getSheetView()->setView(PHPExcel_Worksheet_SheetView::SHEETVIEW_PAGE_LAYOUT);
		$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);

		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(1);
		$this->excel->getActiveSheet(1)->setTitle("Annual Report");
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(10);						
				
		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('PHPExcel logo');
		$objDrawing->setDescription('PHPExcel logo');
		$objDrawing->setPath('./assets/gambar/pln.png');
		$objDrawing->setHeight(100);                
		$objDrawing->setCoordinates('A1');
		$objDrawing->setWorksheet($this->excel->getActiveSheet());

		$objDrawings = new PHPExcel_Worksheet_Drawing();
		$objDrawings->setName('PHPExcel logo');
		$objDrawings->setDescription('PHPExcel logo');
		$objDrawings->setPath('./assets/gambar/pjb.png');
		$objDrawings->setHeight(90);                
		$objDrawings->setCoordinates('L1');
		$objDrawings->setWorksheet($this->excel->getActiveSheet());
						
		$this->excel->getActiveSheet()->mergeCells('D1:K1');				
		$this->excel->getActiveSheet()->setCellValue('D1', 'ANNUAL REPORT');
		$this->excel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);				

		$this->excel->getActiveSheet()->mergeCells('D2:K2');				
		$this->excel->getActiveSheet()->setCellValue('D2', "FLY ASH, BOTTOM ASH, GYPSUM");
		$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);		

		$this->excel->getActiveSheet()->mergeCells('D3:K3');				
		$this->excel->getActiveSheet()->setCellValue('D3', $tahun);
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D3')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);				

		$this->excel->getActiveSheet()->mergeCells('D4:K4');				
		$this->excel->getActiveSheet()->setCellValue('D4', "PLTU TANJUNG JATI B JEPARA");
		$this->excel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D4')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true);				

		$this->excel->getActiveSheet()->mergeCells('A6:A8');		
		$this->excel->getActiveSheet()->setCellValue('A6', 'NO');
		$this->excel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B6:B8');		
		$this->excel->getActiveSheet()->setCellValue('B6', 'MONTH');
		$this->excel->getActiveSheet()->getStyle('B6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);		
		$this->excel->getActiveSheet()->getStyle('A6:N7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('99cc00');
		$jns = array('ASH YARD','OFF TAKING');
		$warna = array('b8cce4','fabf8f');
		$nn = 0;
		$kolom = 2;
		$bawah = 2;
		foreach($jns as $jenis_out)
		{			
			$sampah = $this->arey->getLimbah();
			$jum_sampah = count($sampah);
			$jum_sampah = $jum_sampah*2;
			$awale = $huruf[$kolom];
			$akhire = $huruf[$kolom+$jum_sampah-1];
			$this->excel->getActiveSheet()->mergeCells($awale.'6:'.$akhire.'6');		
			$this->excel->getActiveSheet()->setCellValue($awale.'6', $jenis_out);
			$this->excel->getActiveSheet()->getStyle($awale.'6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle($awale.'6:'.$awale.'6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($warna[$nn]);
			foreach($sampah as $key => $dt_sampah)
			{
				$nkolom = $huruf[$bawah];
				$nkolom1 = $huruf[$bawah+1];
				$this->excel->getActiveSheet()->mergeCells($nkolom.'7:'.$nkolom1.'7');		
				$this->excel->getActiveSheet()->setCellValue($nkolom.'7', $key);
				$this->excel->getActiveSheet()->getStyle($nkolom.'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue($nkolom.'8', '1&2');
				$this->excel->getActiveSheet()->getStyle($nkolom.'8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle($nkolom.'8:'.$nkolom.'8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ccc0da');
				$this->excel->getActiveSheet()->setCellValue($nkolom1.'8', '3&4');
				$this->excel->getActiveSheet()->getStyle($nkolom1.'8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle($nkolom1.'8:'.$nkolom1.'8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('93cddd');
				$bawah+=2;
			}
			$kolom+=$jum_sampah;
			$nn++;
		}

		$baris = 9;
		$no = 1;

		$bulanans = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
		foreach($bulanans as $kunci => $dt_bulan)
		{
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('B'.$baris, $dt_bulan);
			$kolom = 2;
			foreach($jns as $jenis_out)
			{			
				$sampah = $this->arey->getLimbah();
				foreach($sampah as $key => $dt_sampah)
				{					
					$bulss = $kunci+1;
					$satu = $this->mlaporan->getTahunanAll($bulss,$tahun,$dt_sampah['1#2'],$jenis_out);
					$dua = $this->mlaporan->getTahunanAll($bulss,$tahun,$dt_sampah['3#4'],$jenis_out);
					$nkolom = $huruf[$kolom];
					$nkolom1 = $huruf[$kolom+1];
					$this->excel->getActiveSheet()->setCellValue($nkolom.$baris, $satu);
					$this->excel->getActiveSheet()->getStyle($nkolom.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);					
					$this->excel->getActiveSheet()->setCellValue($nkolom1.$baris, $dua);
					$this->excel->getActiveSheet()->getStyle($nkolom1.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$kolom+=2;
				}
			}
			$baris++;
			$no++;
		}
		$this->excel->getActiveSheet()->mergeCells('A'.$baris.':B'.$baris);				
		$this->excel->getActiveSheet()->setCellValue("A".$baris, "Total (Ton)");
		$akhir = $baris-1;
		$this->excel->getActiveSheet()->setCellValue("C".$baris, "=SUM(C8:C".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("C".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("D".$baris, "=SUM(D8:D".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("D".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("E".$baris, "=SUM(E8:E".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("E".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("F".$baris, "=SUM(F8:F".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("F".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("G".$baris, "=SUM(G8:G".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("G".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("H".$baris, "=SUM(H8:H".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("H".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("I".$baris, "=SUM(I8:I".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("I".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("J".$baris, "=SUM(J8:J".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("J".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("K".$baris, "=SUM(K8:K".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("K".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("L".$baris, "=SUM(L8:L".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("L".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("M".$baris, "=SUM(M8:M".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("M".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("N".$baris, "=SUM(N8:N".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("N".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->getStyle('A'.$baris.':N'.$baris)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00');

		$this->excel->getActiveSheet()->freezePane('A9');

		$this->excel->getActiveSheet()->getStyle('A6:N'.$baris)->applyFromArray($styleArray);		
		unset($styleArray);

		$margin = 0.5 / 2.54;

		$this->excel->getActiveSheet()->getPageMargins()->setTop($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setBottom($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setLeft($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setRight($margin);

		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$this->excel->getActiveSheet()->getSheetView()->setView(PHPExcel_Worksheet_SheetView::SHEETVIEW_PAGE_LAYOUT);
		$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);

		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename='Annual_report_'.date('Y-m-d').'.xlsx';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
	}

	function pecahs($barangs)
	{
		$nilai = "";
		foreach($barangs as $barang)	
		{
			$nilai = $nilai."-".$barang;
		}
		return $nilai;
	}

	function generate_custom()
	{
		$tgls = array();

		$kolomsss = array();
		$huruf = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','F','W','X','Y','Z');
		$abjad = array('I','II','III','IV','V');

		//$tanggal = date('Y-m-d');
		$tanggal = $this->input->post('rawal');
		$belakang = abs(8*86400);
		$depan = abs(5*86400);
		$awal = strtotime($tanggal)-$belakang;
		$akhir = strtotime($tanggal)+$depan;
		for($i=$awal;$i<=$akhir;$i+=86400)
		{
			$tgls[] = date('Y-m-d', $i);
		}

		$tglss = $tanggal;
		$pecahss = explode("-", $tglss);
		$tglsa = $pecahss[2]." ".$this->arey->getBulanLap(intval($pecahss[1]))." ".$pecahss[0];

		$tanggal1 = $tgls[0];
		$pecah1 = explode("-", $tanggal1);
		$tanggal1 = $pecah1[2]." ".$this->arey->getBulanLap(intval($pecah1[1]))." ".$pecah1[0];

		$tanggal2 = $tgls[13];
		$pecah2 = explode("-", $tanggal2);
		$tanggal2 = $pecah2[2]." ".$this->arey->getBulanLap(intval($pecah2[1]))." ".$pecah2[0];

		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(0);		
		$objWorksheet = $this->excel->getActiveSheet();
		$lapMinggu = $this->mlaporan->getGraphMingguan($tanggal);
		$jumLapMinggu = count($lapMinggu);
		$objWorksheet->fromArray($lapMinggu);
	
		//laporan fly ash 1#2
		$dataseriesLabels1 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$1', NULL, 1),	//	2010
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$1', NULL, 1),	//	2011						
		);
		
		$xAxisTickValues1 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$'.$jumLapMinggu, NULL, 4),	//	Q1 to Q4
		);
		
		$dataSeriesValues1 = array(
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$B$2:$B$'.$jumLapMinggu, NULL, 4),
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$2:$C$'.$jumLapMinggu, NULL, 4),						
		);

		$series1 = new PHPExcel_Chart_DataSeries(
			PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
			PHPExcel_Chart_DataSeries::GROUPING_STACKED,	// plotGrouping
			range(0, count($dataSeriesValues1)-1),			// plotOrder
			$dataseriesLabels1,								// plotLabel
			$xAxisTickValues1,								// plotCategory
			$dataSeriesValues1								// plotValues
		);
		
		$series1->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

		$plotarea1 = new PHPExcel_Chart_PlotArea(NULL, array($series1));
	
		$legend1 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

		$title1 = new PHPExcel_Chart_Title('WEEKLY REPORT FLY ASH 1&2');
		$yAxisLabel1 = new PHPExcel_Chart_Title('Total (Ton)');

		$chart1 = new PHPExcel_Chart(
			'chart1',		// name
			$title1,			// title
			$legend1,		// legend
			$plotarea1,		// plotArea
			true,			// plotVisibleOnly
			0,				// displayBlanksAs
			NULL,			// xAxisLabel
			$yAxisLabel1		// yAxisLabel
		);

		$chart1->setTopLeftPosition('A1');
		$chart1->setBottomRightPosition('H25');

		$objWorksheet->addChart($chart1);

		//laporan fly ash 3#4
		$dataseriesLabels2 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$1', NULL, 1),	//	2010
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$1', NULL, 1),	//	2011						
		);
		
		$xAxisTickValues2 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$'.$jumLapMinggu, NULL, 4),	//	Q1 to Q4
		);
		
		$dataSeriesValues2 = array(
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$2:$D$'.$jumLapMinggu, NULL, 4),
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$E$2:$E$'.$jumLapMinggu, NULL, 4),						
		);

		$series2 = new PHPExcel_Chart_DataSeries(
			PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
			PHPExcel_Chart_DataSeries::GROUPING_STACKED,	// plotGrouping
			range(0, count($dataSeriesValues2)-1),			// plotOrder
			$dataseriesLabels2,								// plotLabel
			$xAxisTickValues2,								// plotCategory
			$dataSeriesValues2								// plotValues
		);
		
		$series2->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

		$plotarea2 = new PHPExcel_Chart_PlotArea(NULL, array($series2));
	
		$legend2 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

		$title2 = new PHPExcel_Chart_Title('WEEKLY REPORT FLY ASH 3&4');
		$yAxisLabel2 = new PHPExcel_Chart_Title('Total (Ton)');

		$chart2 = new PHPExcel_Chart(
			'chart2',		// name
			$title2,			// title
			$legend2,		// legend
			$plotarea2,		// plotArea
			true,			// plotVisibleOnly
			0,				// displayBlanksAs
			NULL,			// xAxisLabel
			$yAxisLabel2		// yAxisLabel
		);

		$chart2->setTopLeftPosition('H1');
		$chart2->setBottomRightPosition('O25');

		$objWorksheet->addChart($chart2);

		//laporan bottom ash 1#2
		$dataseriesLabels3 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$1', NULL, 1),	//	2010
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$1', NULL, 1),	//	2011						
		);
		
		$xAxisTickValues3 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$'.$jumLapMinggu, NULL, 4),	//	Q1 to Q4
		);
		
		$dataSeriesValues3 = array(
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$F$2:$F$'.$jumLapMinggu, NULL, 4),
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$G$2:$G$'.$jumLapMinggu, NULL, 4),						
		);

		$series3 = new PHPExcel_Chart_DataSeries(
			PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
			PHPExcel_Chart_DataSeries::GROUPING_STACKED,	// plotGrouping
			range(0, count($dataSeriesValues3)-1),			// plotOrder
			$dataseriesLabels3,								// plotLabel
			$xAxisTickValues3,								// plotCategory
			$dataSeriesValues3								// plotValues
		);
		
		$series3->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

		$plotarea3 = new PHPExcel_Chart_PlotArea(NULL, array($series3));
	
		$legend3 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

		$title3 = new PHPExcel_Chart_Title('WEEKLY REPORT BOTTOM ASH 1&2');
		$yAxisLabel3 = new PHPExcel_Chart_Title('Total (Ton)');

		$chart3 = new PHPExcel_Chart(
			'chart3',		// name
			$title3,			// title
			$legend3,		// legend
			$plotarea3,		// plotArea
			true,			// plotVisibleOnly
			0,				// displayBlanksAs
			NULL,			// xAxisLabel
			$yAxisLabel3		// yAxisLabel
		);

		$chart3->setTopLeftPosition('A26');
		$chart3->setBottomRightPosition('H50');

		$objWorksheet->addChart($chart3);

		//laporan bottom ash 3#4
		$dataseriesLabels4 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$1', NULL, 1),	//	2010
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$1', NULL, 1),	//	2011						
		);
		
		$xAxisTickValues4 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$'.$jumLapMinggu, NULL, 4),	//	Q1 to Q4
		);
		
		$dataSeriesValues4 = array(
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$2:$D$'.$jumLapMinggu, NULL, 4),
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$E$2:$E$'.$jumLapMinggu, NULL, 4),						
		);

		$series4 = new PHPExcel_Chart_DataSeries(
			PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
			PHPExcel_Chart_DataSeries::GROUPING_STACKED,	// plotGrouping
			range(0, count($dataSeriesValues4)-1),			// plotOrder
			$dataseriesLabels4,								// plotLabel
			$xAxisTickValues4,								// plotCategory
			$dataSeriesValues4								// plotValues
		);
		
		$series4->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

		$plotarea4 = new PHPExcel_Chart_PlotArea(NULL, array($series4));
	
		$legend4 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

		$title4 = new PHPExcel_Chart_Title('WEEKLY REPORT BOTTOM ASH 3&4');
		$yAxisLabel4 = new PHPExcel_Chart_Title('Total (Ton)');

		$chart4 = new PHPExcel_Chart(
			'chart4',		// name
			$title4,			// title
			$legend4,		// legend
			$plotarea4,		// plotArea
			true,			// plotVisibleOnly
			0,				// displayBlanksAs
			NULL,			// xAxisLabel
			$yAxisLabel4		// yAxisLabel
		);

		$chart4->setTopLeftPosition('H26');
		$chart4->setBottomRightPosition('O50');

		$objWorksheet->addChart($chart4);

		//laporan gypsum 1#2
		$dataseriesLabels5 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$1', NULL, 1),	//	2010
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$1', NULL, 1),	//	2011						
		);
		
		$xAxisTickValues5 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$'.$jumLapMinggu, NULL, 4),	//	Q1 to Q4
		);
		
		$dataSeriesValues5 = array(
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$H$2:$H$'.$jumLapMinggu, NULL, 4),
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$I$2:$I$'.$jumLapMinggu, NULL, 4),						
		);

		$series5 = new PHPExcel_Chart_DataSeries(
			PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
			PHPExcel_Chart_DataSeries::GROUPING_STACKED,	// plotGrouping
			range(0, count($dataSeriesValues5)-1),			// plotOrder
			$dataseriesLabels5,								// plotLabel
			$xAxisTickValues5,								// plotCategory
			$dataSeriesValues5								// plotValues
		);
		
		$series5->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

		$plotarea5 = new PHPExcel_Chart_PlotArea(NULL, array($series5));
	
		$legend5 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

		$title5 = new PHPExcel_Chart_Title('WEEKLY REPORT GYPSUM 1&2');
		$yAxisLabel5 = new PHPExcel_Chart_Title('Total (Ton)');

		$chart5 = new PHPExcel_Chart(
			'chart5',		// name
			$title5,			// title
			$legend5,		// legend
			$plotarea5,		// plotArea
			true,			// plotVisibleOnly
			0,				// displayBlanksAs
			NULL,			// xAxisLabel
			$yAxisLabel5		// yAxisLabel
		);

		$chart5->setTopLeftPosition('A51');
		$chart5->setBottomRightPosition('H75');

		$objWorksheet->addChart($chart5);

		//laporan gypsum 3#4
		$dataseriesLabels6 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$1', NULL, 1),	//	2010
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$1', NULL, 1),	//	2011						
		);
		
		$xAxisTickValues6 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$'.$jumLapMinggu, NULL, 4),	//	Q1 to Q4
		);
		
		$dataSeriesValues6 = array(
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$2:$D$'.$jumLapMinggu, NULL, 4),
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$E$2:$E$'.$jumLapMinggu, NULL, 4),						
		);

		$series6 = new PHPExcel_Chart_DataSeries(
			PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
			PHPExcel_Chart_DataSeries::GROUPING_STACKED,	// plotGrouping
			range(0, count($dataSeriesValues6)-1),			// plotOrder
			$dataseriesLabels6,								// plotLabel
			$xAxisTickValues6,								// plotCategory
			$dataSeriesValues6								// plotValues
		);
		
		$series6->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

		$plotarea6 = new PHPExcel_Chart_PlotArea(NULL, array($series6));
	
		$legend6 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

		$title6 = new PHPExcel_Chart_Title('WEEKLY REPORT GYPSUM 3&4');
		$yAxisLabel6 = new PHPExcel_Chart_Title('Total (Ton)');

		$chart6 = new PHPExcel_Chart(
			'chart6',		// name
			$title6,			// title
			$legend6,		// legend
			$plotarea6,		// plotArea
			true,			// plotVisibleOnly
			0,				// displayBlanksAs
			NULL,			// xAxisLabel
			$yAxisLabel6		// yAxisLabel
		);

		$chart6->setTopLeftPosition('H51');
		$chart6->setBottomRightPosition('O75');

		$objWorksheet->addChart($chart6);

		$margin = 0.5 / 2.54;

		$this->excel->getActiveSheet()->getPageMargins()->setTop($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setBottom($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setLeft($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setRight($margin);

		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$this->excel->getActiveSheet()->getSheetView()->setView(PHPExcel_Worksheet_SheetView::SHEETVIEW_PAGE_LAYOUT);
		$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);

		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);		

		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(1);
		$this->excel->getActiveSheet(1)->setTitle("Weekly Report");
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(10);				
		$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(10);				
				
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('PHPExcel logo');
		$objDrawing->setDescription('PHPExcel logo');
		$objDrawing->setPath('./assets/gambar/pln.png');
		$objDrawing->setHeight(100);                
		$objDrawing->setCoordinates('A1');
		$objDrawing->setWorksheet($this->excel->getActiveSheet());

		$objDrawings = new PHPExcel_Worksheet_Drawing();
		$objDrawings->setName('PHPExcel logo');
		$objDrawings->setDescription('PHPExcel logo');
		$objDrawings->setPath('./assets/gambar/pjb.png');
		$objDrawings->setHeight(90);                
		$objDrawings->setCoordinates('M1');
		$objDrawings->setWorksheet($this->excel->getActiveSheet());
						
		$this->excel->getActiveSheet()->mergeCells('D1:L1');				
		$this->excel->getActiveSheet()->setCellValue('D1', 'WEEKLY REPORT');
		$this->excel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);				

		$this->excel->getActiveSheet()->mergeCells('D2:L2');				
		$this->excel->getActiveSheet()->setCellValue('D2', "FLY ASH, BOTTOM ASH, GYPSUM");
		$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);		

		$this->excel->getActiveSheet()->mergeCells('D3:L3');				
		$this->excel->getActiveSheet()->setCellValue('D3', "PERIOD (".$this->tanggals($tgls[0])." - ".$this->tanggals($tgls[13]).")");
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D3')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);				

		$this->excel->getActiveSheet()->mergeCells('D4:L4');				
		$this->excel->getActiveSheet()->setCellValue('D4', "PLTU TANJUNG JATI B JEPARA");
		$this->excel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D4')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true);				

		$this->excel->getActiveSheet()->mergeCells('A6:A8');		
		$this->excel->getActiveSheet()->setCellValue('A6', 'NO');
		$this->excel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B6:B8');		
		$this->excel->getActiveSheet()->setCellValue('B6', 'WEEK');
		$this->excel->getActiveSheet()->getStyle('B6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('C6:C8');		
		$this->excel->getActiveSheet()->setCellValue('C6', 'DATE');
		$this->excel->getActiveSheet()->getStyle('C6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('C6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A6:O8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('99cc00');
		$jns = array('ASH YARD','OFF TAKING');
		$warna = array('b8cce4','fabf8f');
		$nn = 0;
		$kolom = 3;
		$bawah = 3;
		foreach($jns as $jenis_out)
		{			
			$sampah = $this->arey->getLimbah();
			$jum_sampah = count($sampah);
			$jum_sampah = $jum_sampah*2;
			$awale = $huruf[$kolom];
			$akhire = $huruf[$kolom+$jum_sampah-1];
			$this->excel->getActiveSheet()->mergeCells($awale.'6:'.$akhire.'6');		
			$this->excel->getActiveSheet()->setCellValue($awale.'6', $jenis_out);
			$this->excel->getActiveSheet()->getStyle($awale.'6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle($awale.'6:'.$awale.'6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($warna[$nn]);
			foreach($sampah as $key => $dt_sampah)
			{
				$nkolom = $huruf[$bawah];
				$nkolom1 = $huruf[$bawah+1];
				$this->excel->getActiveSheet()->mergeCells($nkolom.'7:'.$nkolom1.'7');		
				$this->excel->getActiveSheet()->setCellValue($nkolom.'7', $key);
				$this->excel->getActiveSheet()->getStyle($nkolom.'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue($nkolom.'8', '1&2');
				$this->excel->getActiveSheet()->getStyle($nkolom.'8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle($nkolom.'8:'.$nkolom.'8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ccc0da');
				$this->excel->getActiveSheet()->setCellValue($nkolom1.'8', '3&4');
				$this->excel->getActiveSheet()->getStyle($nkolom1.'8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle($nkolom1.'8:'.$nkolom1.'8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('93cddd');
				$bawah+=2;
			}
			$kolom+=$jum_sampah;
			$nn++;
		}

		$baris = 9;
		$no=1;
		foreach($tgls as $key => $dt_tgls)
		{
			$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);			
			$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
			if($key == 0)
			{
				$this->excel->getActiveSheet()->setCellValue('B'.$baris, "I");
			}
			elseif($key == 7)
			{
				$this->excel->getActiveSheet()->setCellValue('B'.$baris, "II");
			}
			$this->excel->getActiveSheet()->setCellValue('C'.$baris, $this->tanggals($dt_tgls));
			$kolom = 3;
			foreach($jns as $jenis_out)
			{			
				$sampah = $this->arey->getLimbah();
				foreach($sampah as $key => $dt_sampah)
				{					
					$satu = $this->mlaporan->getCustom($dt_tgls,$dt_sampah['1#2'],$jenis_out);
					$dua = $this->mlaporan->getCustom($dt_tgls,$dt_sampah['3#4'],$jenis_out);
					$nkolom = $huruf[$kolom];
					$nkolom1 = $huruf[$kolom+1];
					$this->excel->getActiveSheet()->setCellValue($nkolom.$baris, $satu);
					$this->excel->getActiveSheet()->getStyle($nkolom.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
					$this->excel->getActiveSheet()->setCellValue($nkolom1.$baris, $dua);
					$this->excel->getActiveSheet()->getStyle($nkolom1.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
					$kolom+=2;
				}
			}
			$no++;
			$baris++;
		}
		$this->excel->getActiveSheet()->mergeCells('A'.$baris.':C'.$baris);				
		$this->excel->getActiveSheet()->setCellValue("A".$baris, "Total (Ton)");
		$akhir = $baris-1;
		$this->excel->getActiveSheet()->setCellValue("D".$baris, "=SUM(D8:D".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("D".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("E".$baris, "=SUM(E8:E".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("E".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("F".$baris, "=SUM(F8:F".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("F".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("G".$baris, "=SUM(G8:G".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("G".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("H".$baris, "=SUM(H8:H".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("H".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("I".$baris, "=SUM(I8:I".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("I".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("J".$baris, "=SUM(J8:J".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("J".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("K".$baris, "=SUM(K8:K".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("K".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("L".$baris, "=SUM(L8:L".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("L".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("M".$baris, "=SUM(M8:M".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("M".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("N".$baris, "=SUM(N8:N".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("N".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue("O".$baris, "=SUM(O8:O".$akhir.")");		
		$this->excel->getActiveSheet()->getStyle("O".$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->getStyle('A'.$baris.':O'.$baris)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00');
		$this->excel->getActiveSheet()->freezePane('A9');

		$this->excel->getActiveSheet()->getStyle('A6:O'.$baris)->applyFromArray($styleArray);		
		unset($styleArray);
		

		$margin = 0.5 / 2.54;

		$this->excel->getActiveSheet()->getPageMargins()->setTop($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setBottom($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setLeft($margin);
		$this->excel->getActiveSheet()->getPageMargins()->setRight($margin);

		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$this->excel->getActiveSheet()->getSheetView()->setView(PHPExcel_Worksheet_SheetView::SHEETVIEW_PAGE_LAYOUT);
		$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);

		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename='Weekly_report_'.date('Y-m-d').'.xlsx';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
	}

	function generate_klh()
	{
		$kolomsss = array();
		$huruf = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','F','W','X','Y','Z');
		$abjad = array('I','II','III','IV','V');
		$bulanans = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
		
		$bulan = $this->input->post('bulan',TRUE);
		$tahun = $this->input->post('thn',TRUE);
		$bulan = intval($bulan);	
		$bul_akhir = $bulan+2;

		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet(0)->setTitle("LapKLH");
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('V')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('W')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('X')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('Y')->setWidth(15);
				
		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('PHPExcel logo');
		$objDrawing->setDescription('PHPExcel logo');
		$objDrawing->setPath('./assets/gambar/pln.png');
		$objDrawing->setHeight(100);                
		$objDrawing->setCoordinates('A1');
		$objDrawing->setWorksheet($this->excel->getActiveSheet());		
						
		$this->excel->getActiveSheet()->mergeCells('D1:W1');				
		$this->excel->getActiveSheet()->setCellValue('D1', 'Penimbunan Limbah Fly Ash, Bottom Ash');
		$this->excel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);				

		$this->excel->getActiveSheet()->mergeCells('D2:W2');				
		$this->excel->getActiveSheet()->setCellValue('D2', "PT PLN (Persero) Pembangkitan Tanjung Jati B");
		$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);				

		$this->excel->getActiveSheet()->mergeCells('D3:W3');				
		$this->excel->getActiveSheet()->setCellValue('D3', "UNIT 1-2-3-4");
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D3')->getFont()->setSize(15);
		$this->excel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);				

		$this->excel->getActiveSheet()->setCellValue('A5', "Umur Penimbunan");
		$this->excel->getActiveSheet()->setCellValue('D5', ": 5 Tahun");
		$this->excel->getActiveSheet()->setCellValue('A6', "Kapasitas Area Penimbunan");
		$this->excel->getActiveSheet()->setCellValue('D6', ": 143.555 m2");
		$this->excel->getActiveSheet()->setCellValue('A7', "Periode");
		$this->excel->getActiveSheet()->setCellValue('D7', ": ".$bulanans[$bulan-1]." - ".$bulanans[$bul_akhir-1]." ".$tahun);

		
		$this->excel->getActiveSheet()->mergeCells('A8:A9');		
		$this->excel->getActiveSheet()->setCellValue('A8', 'NO');
		$this->excel->getActiveSheet()->getStyle('A8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('B8:B9');		
		$this->excel->getActiveSheet()->setCellValue('B8', 'Tanggal Masuk ke Lokasi Penimbunan');
		$this->excel->getActiveSheet()->getStyle('B8')->getAlignment()->setWrapText(true);
		$this->excel->getActiveSheet()->getStyle('B8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('C8:D8');		
		$this->excel->getActiveSheet()->setCellValue('C8', 'Coal');				
		$this->excel->getActiveSheet()->getStyle('C8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('C9', 'Unit 1');				
		$this->excel->getActiveSheet()->getStyle('C9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('D9', 'Unit 2');
		$this->excel->getActiveSheet()->getStyle('D9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('E8:E9');		
		$this->excel->getActiveSheet()->setCellValue('E8', 'Plant');
		$this->excel->getActiveSheet()->getStyle('E8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('E8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('F8:G8');		
		$this->excel->getActiveSheet()->setCellValue('F8', 'Coal Consumption');		
		$this->excel->getActiveSheet()->getStyle('F8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('F9', 'U3');		
		$this->excel->getActiveSheet()->getStyle('F9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('G9', 'U4');
		$this->excel->getActiveSheet()->getStyle('G9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('H8:H9');		
		$this->excel->getActiveSheet()->setCellValue('H8', 'Plant');
		$this->excel->getActiveSheet()->getStyle('H8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('H8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('I8:I9');		
		$this->excel->getActiveSheet()->setCellValue('I8', 'Total');
		$this->excel->getActiveSheet()->getStyle('I8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('I8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('J8:J9');		
		$this->excel->getActiveSheet()->setCellValue('J8', 'Jenis Limbah');
		$this->excel->getActiveSheet()->getStyle('J8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('J8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('K8:K9');		
		$this->excel->getActiveSheet()->setCellValue('K8', 'Sumber Limbah');
		$this->excel->getActiveSheet()->getStyle('K8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('K8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('L8:M8');		
		$this->excel->getActiveSheet()->setCellValue('L8', 'Jumlah FA di timbun (Ton)');
		$this->excel->getActiveSheet()->getStyle('L8')->getAlignment()->setWrapText(true);	
		$this->excel->getActiveSheet()->getStyle('L8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('L9', 'Unit 1&2');		
		$this->excel->getActiveSheet()->getStyle('L9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('M9', 'Unit 3&4');
		$this->excel->getActiveSheet()->getStyle('M9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('N8:N9');		
		$this->excel->getActiveSheet()->setCellValue('N8', 'Akumulasi Total (Ton)');
		$this->excel->getActiveSheet()->getStyle('N8')->getAlignment()->setWrapText(true);
		$this->excel->getActiveSheet()->getStyle('N8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('N8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('O8:O9');		
		$this->excel->getActiveSheet()->setCellValue('O8', 'Akumulasi FA ditimbun (Ton)');
		$this->excel->getActiveSheet()->getStyle('O8')->getAlignment()->setWrapText(true);
		$this->excel->getActiveSheet()->getStyle('O8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('O8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('P8:Q8');		
		$this->excel->getActiveSheet()->setCellValue('P8', 'Dimanfaatkan (Ton)');		
		$this->excel->getActiveSheet()->getStyle('P8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('P9', 'Unit #1&2');		
		$this->excel->getActiveSheet()->getStyle('P9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('Q9', 'Unit #3&4');
		$this->excel->getActiveSheet()->getStyle('Q9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('R8:R9');		
		$this->excel->getActiveSheet()->setCellValue('R8', 'Akumulasi Pemanfaatan (Ton)');
		$this->excel->getActiveSheet()->getStyle('R8')->getAlignment()->setWrapText(true);
		$this->excel->getActiveSheet()->getStyle('R8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('R8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('S8:T8');		
		$this->excel->getActiveSheet()->setCellValue('S8', 'Jumlah BA di timbun (Ton)');	
		$this->excel->getActiveSheet()->getStyle('S8')->getAlignment()->setWrapText(true);	
		$this->excel->getActiveSheet()->getStyle('S8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('S9', 'Unit 1&2');		
		$this->excel->getActiveSheet()->getStyle('S9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('T9', 'Unit 3&4');
		$this->excel->getActiveSheet()->getStyle('T9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('U8:U9');		
		$this->excel->getActiveSheet()->setCellValue('U8', 'Akumulasi Total (Ton)');
		$this->excel->getActiveSheet()->getStyle('U8')->getAlignment()->setWrapText(true);
		$this->excel->getActiveSheet()->getStyle('U8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('U8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('V8:V9');		
		$this->excel->getActiveSheet()->setCellValue('V8', 'Akumulasi BA ditimbun (Ton)');
		$this->excel->getActiveSheet()->getStyle('V8')->getAlignment()->setWrapText(true);
		$this->excel->getActiveSheet()->getStyle('V8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('V8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('W8:X8');		
		$this->excel->getActiveSheet()->setCellValue('W8', 'Dimanfaatkan (Ton)');			
		$this->excel->getActiveSheet()->getStyle('W8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('W9', 'Unit #1&2');			
		$this->excel->getActiveSheet()->getStyle('W9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('X9', 'Unit #3&4');
		$this->excel->getActiveSheet()->getStyle('X9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('Y8:Y9');		
		$this->excel->getActiveSheet()->setCellValue('Y8', 'Akumulasi Pemanfaatan (Ton)');
		$this->excel->getActiveSheet()->getStyle('Y8')->getAlignment()->setWrapText(true);
		$this->excel->getActiveSheet()->getStyle('Y8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('Y8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		$jumlah = array('31','29','31','30','31','30','31','31','30','31','30','31');
				
		$baris = 11;
		$no = 1;
		for($i=$bulan;$i<=$bul_akhir;$i++)
		{
			$jumlah_hari = $jumlah[$i-1];			
			for($j=1;$j<=$jumlah_hari;$j++)
			{
				$tglh = $tahun."-".$i."-".$j;
				$tanggalb = $this->tanggals($tglh);
				$this->excel->getActiveSheet()->setCellValue('A'.$baris, $j);
				$this->excel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
				$satu = $this->mlaporan->getCustom($tglh,array('1','21'),'LAGOON');				
				$dua = $this->mlaporan->getCustom($tglh,array('2','22'),'LAGOON');				
				$this->excel->getActiveSheet()->setCellValue('L'.$baris, $satu);
				$this->excel->getActiveSheet()->getStyle('L'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
				$this->excel->getActiveSheet()->setCellValue('M'.$baris, $dua);
				$this->excel->getActiveSheet()->getStyle('M'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
				$this->excel->getActiveSheet()->setCellValue('N'.$baris, "=SUM(L".$baris.":M".$baris.")");
				$this->excel->getActiveSheet()->getStyle('N'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
				$this->excel->getActiveSheet()->setCellValue('O'.$baris, "=N".$baris);
				$this->excel->getActiveSheet()->getStyle('O'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	

				$tiga = $this->mlaporan->getCustom($tglh,array('1','21'),'ASH YARD');				
				$empat = $this->mlaporan->getCustom($tglh,array('2','22'),'ASH YARD');				
				$this->excel->getActiveSheet()->setCellValue('P'.$baris, $tiga);
				$this->excel->getActiveSheet()->getStyle('P'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
				$this->excel->getActiveSheet()->setCellValue('Q'.$baris, $empat);
				$this->excel->getActiveSheet()->getStyle('Q'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
				$this->excel->getActiveSheet()->setCellValue('R'.$baris, "=SUM(P".$baris.":Q".$baris.")");
				$this->excel->getActiveSheet()->getStyle('R'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	

				$lima = $this->mlaporan->getCustom($tglh,array('5','25'),'LAGOON');				
				$enam = $this->mlaporan->getCustom($tglh,array('6'),'LAGOON');				
				$this->excel->getActiveSheet()->setCellValue('S'.$baris, $lima);
				$this->excel->getActiveSheet()->getStyle('S'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
				$this->excel->getActiveSheet()->setCellValue('T'.$baris, $enam);
				$this->excel->getActiveSheet()->getStyle('T'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
				$this->excel->getActiveSheet()->setCellValue('U'.$baris, "=SUM(S".$baris.":T".$baris.")");
				$this->excel->getActiveSheet()->getStyle('U'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
				$this->excel->getActiveSheet()->setCellValue('V'.$baris, "=U".$baris);
				$this->excel->getActiveSheet()->getStyle('V'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	

				$tujuh = $this->mlaporan->getCustom($tglh,array('5','25'),'ASH YARD');				
				$delapan = $this->mlaporan->getCustom($tglh,array('6'),'ASH YARD');				
				$this->excel->getActiveSheet()->setCellValue('W'.$baris, $tujuh);
				$this->excel->getActiveSheet()->getStyle('W'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
				$this->excel->getActiveSheet()->setCellValue('X'.$baris, $delapan);
				$this->excel->getActiveSheet()->getStyle('X'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
				$this->excel->getActiveSheet()->setCellValue('Y'.$baris, "=SUM(P".$baris.":Q".$baris.")");
				$this->excel->getActiveSheet()->getStyle('Y'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	

				$this->excel->getActiveSheet()->setCellValue('B'.$baris, $tanggalb);				
				$baris++;
				$no++;
			}			
		}		

		$this->excel->getActiveSheet()->freezePane('A10');

		$baris = $baris-1;

		$this->excel->getActiveSheet()->setCellValue('L10', "=SUM(L11:L".$baris.")");
		$this->excel->getActiveSheet()->getStyle('L10')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue('M10', "=SUM(M11:M".$baris.")");
		$this->excel->getActiveSheet()->getStyle('M10')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue('N10', "=SUM(N11:N".$baris.")");
		$this->excel->getActiveSheet()->getStyle('N10')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue('O10', "=SUM(O11:O".$baris.")");
		$this->excel->getActiveSheet()->getStyle('O10')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	

		$this->excel->getActiveSheet()->setCellValue('P10', "=SUM(P11:P".$baris.")");
		$this->excel->getActiveSheet()->getStyle('P10')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue('Q10', "=SUM(Q11:Q".$baris.")");
		$this->excel->getActiveSheet()->getStyle('Q10')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue('R10', "=SUM(R11:R".$baris.")");
		$this->excel->getActiveSheet()->getStyle('R10')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	

		$this->excel->getActiveSheet()->setCellValue('S10', "=SUM(S11:S".$baris.")");
		$this->excel->getActiveSheet()->getStyle('S10')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue('T10', "=SUM(T11:T".$baris.")");
		$this->excel->getActiveSheet()->getStyle('T10')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue('U10', "=SUM(U11:U".$baris.")");
		$this->excel->getActiveSheet()->getStyle('U10')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue('V10', "=SUM(V11:V".$baris.")");
		$this->excel->getActiveSheet()->getStyle('V10')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		
		$this->excel->getActiveSheet()->setCellValue('W10', "=SUM(W11:W".$baris.")");
		$this->excel->getActiveSheet()->getStyle('W10')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue('X10', "=SUM(X11:X".$baris.")");
		$this->excel->getActiveSheet()->getStyle('X10')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue('Y10', "=SUM(Y11:Y".$baris.")");
		$this->excel->getActiveSheet()->getStyle('Y10')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	

		$this->excel->getActiveSheet()->getStyle('A8:Y'.$baris)->applyFromArray($styleArray);
		//$this->excel->getActiveSheet()->getStyle('A6:N7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('99cc00');
		unset($styleArray);


		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(1);
		$this->excel->getActiveSheet(1)->setTitle("BalanceB3");
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(45);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(45);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);		
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);		
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);		
				
		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
									
		$this->excel->getActiveSheet()->mergeCells('A1:E1');									
		$this->excel->getActiveSheet()->setCellValue('A1', 'BALANCE OF HAZARDOUS WASTE');
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);						

		$this->excel->getActiveSheet()->setCellValue('A3', "Company Name");
		$this->excel->getActiveSheet()->setCellValue('B3', ": PLTU Tanjung Jati B");
		$this->excel->getActiveSheet()->setCellValue('A4', "Business Activities");
		$this->excel->getActiveSheet()->setCellValue('B4', ": Coal Fired Power Plant");
		$this->excel->getActiveSheet()->setCellValue('A5', "Time Period");
		$this->excel->getActiveSheet()->setCellValue('B5', ": ".$bulanans[$bulan-1]." - ".$bulanans[$bul_akhir-1]." ".$tahun);

					
		$this->excel->getActiveSheet()->setCellValue('A7', 'INITIAL WASTE TYPE');
		$this->excel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
		$this->excel->getActiveSheet()->setCellValue('B7', 'NUMBER OF INITIAL WASTE TYPE (Ton)');
		$this->excel->getActiveSheet()->getStyle('B7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
		$this->excel->getActiveSheet()->mergeCells('C7:E7');		
		$this->excel->getActiveSheet()->setCellValue('C7', 'NOTE');				
		$this->excel->getActiveSheet()->getStyle('C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		

		$this->excel->getActiveSheet()->setCellValue('A8', 'UNIT 3-4');
		$this->excel->getActiveSheet()->mergeCells('A8:A8');
		$this->excel->getActiveSheet()->getStyle('A8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
		$this->excel->getActiveSheet()->setCellValue('A9', 'INITIAL WASTE TYPE');		
		$this->excel->getActiveSheet()->mergeCells('A9:A9');
		$this->excel->getActiveSheet()->setCellValue('A10', 'Used Oil');
		$this->excel->getActiveSheet()->mergeCells('A10:A10');
		$this->excel->getActiveSheet()->setCellValue('A11', 'Contaminated rags');
		$this->excel->getActiveSheet()->mergeCells('A11:A11');
		$this->excel->getActiveSheet()->setCellValue('A12', 'Used TL& Mercury Lamp');
		$this->excel->getActiveSheet()->mergeCells('A12:A12');
		$this->excel->getActiveSheet()->setCellValue('A13', 'Used Resin');
		$this->excel->getActiveSheet()->mergeCells('A13:A13');
		$this->excel->getActiveSheet()->setCellValue('A14', 'Used Battery/Accu');
		$this->excel->getActiveSheet()->mergeCells('A14:A14');
		$this->excel->getActiveSheet()->setCellValue('A15', 'Bottom Ash');
		$this->excel->getActiveSheet()->mergeCells('A15:A15');
		$this->excel->getActiveSheet()->setCellValue('A16', 'Fly Ash');
		$this->excel->getActiveSheet()->mergeCells('A16:A16');
		$this->excel->getActiveSheet()->setCellValue('A17', 'Used Chem Bottle');
		$this->excel->getActiveSheet()->mergeCells('A17:A17');
		$this->excel->getActiveSheet()->setCellValue('A18', 'Sludge WWT');
		$this->excel->getActiveSheet()->mergeCells('A18:A18');
		$this->excel->getActiveSheet()->setCellValue('A19', 'Expired Chemical');
		$this->excel->getActiveSheet()->mergeCells('A19:A19');
		$this->excel->getActiveSheet()->setCellValue('A20', 'Used Filter');
		$this->excel->getActiveSheet()->mergeCells('A20:A20');
		$this->excel->getActiveSheet()->setCellValue('A21', 'Used Carbon Brush');
		$this->excel->getActiveSheet()->mergeCells('A21:A21');
		$this->excel->getActiveSheet()->setCellValue('A22', 'Used Printer Toner');
		$this->excel->getActiveSheet()->mergeCells('A22:A22');
		$this->excel->getActiveSheet()->setCellValue('A23', 'Used Paint');
		$this->excel->getActiveSheet()->mergeCells('A23:A23');
		$this->excel->getActiveSheet()->setCellValue('A24', 'TOTAL');
		$this->excel->getActiveSheet()->mergeCells('A24:A24');

		$this->excel->getActiveSheet()->getStyle('A7:E24')->applyFromArray($styleArray);				

		$this->excel->getActiveSheet()->mergeCells('A26:A27');
		$this->excel->getActiveSheet()->setCellValue('A26', 'HANDLING');
		$this->excel->getActiveSheet()->getStyle('A26')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
		$this->excel->getActiveSheet()->mergeCells('B26:B27');
		$this->excel->getActiveSheet()->setCellValue('B26', 'NUMBER OF WASTE (TON)');
		$this->excel->getActiveSheet()->getStyle('B26')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
		$this->excel->getActiveSheet()->mergeCells('C26:C27');		
		$this->excel->getActiveSheet()->setCellValue('C26', 'MANAGED WASTE TYPE');				
		$this->excel->getActiveSheet()->getStyle('C26')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('D26:E26');		
		$this->excel->getActiveSheet()->setCellValue('D26', 'KLH HAZARDOUS');				
		$this->excel->getActiveSheet()->getStyle('D26')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
		$this->excel->getActiveSheet()->setCellValue('D27', 'V');				
		$this->excel->getActiveSheet()->getStyle('D27')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
		$this->excel->getActiveSheet()->setCellValue('E27', 'X');				
		$this->excel->getActiveSheet()->getStyle('E27')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				

		$this->excel->getActiveSheet()->setCellValue('A28', 'STORED');
		$this->excel->getActiveSheet()->setCellValue('C28', 'Used Oil');
		$this->excel->getActiveSheet()->setCellValue('C29', 'Contaminated Rags');		
		$this->excel->getActiveSheet()->setCellValue('A30', 'REUSE');
		$this->excel->getActiveSheet()->setCellValue('A32', 'TREATED');
		$this->excel->getActiveSheet()->setCellValue('A33', 'LANDFILLED');
		$this->excel->getActiveSheet()->setCellValue('B33', "=LapKLH!V10");
		$this->excel->getActiveSheet()->getStyle('B33')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue('C33', 'Bottom Ash');
		$this->excel->getActiveSheet()->setCellValue('B34', "=LapKLH!O10");
		$this->excel->getActiveSheet()->getStyle('B34')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue('C34', 'Fly Ash');
		$this->excel->getActiveSheet()->setCellValue('A36', 'GIVEN TO OTHER');
		$this->excel->getActiveSheet()->setCellValue('C36', 'Sludge');
		$this->excel->getActiveSheet()->setCellValue('B37', "=LapKLH!Y10");
		$this->excel->getActiveSheet()->getStyle('B37')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue('C37', 'Bottom Ash');		
		$this->excel->getActiveSheet()->setCellValue('B38', "=LapKLH!R10");
		$this->excel->getActiveSheet()->getStyle('B38')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$this->excel->getActiveSheet()->setCellValue('C38', 'Fly Ash');
		$this->excel->getActiveSheet()->setCellValue('C39', 'Used Chem Bottle');
		$this->excel->getActiveSheet()->setCellValue('C40', 'Used TL& Mercury Lamp');
		$this->excel->getActiveSheet()->setCellValue('C41', 'Used Resin');
		$this->excel->getActiveSheet()->setCellValue('C42', 'Used Battery/Accu');
		$this->excel->getActiveSheet()->setCellValue('C43', 'Expired Chemical');
		$this->excel->getActiveSheet()->setCellValue('C44', 'Used Filter');
		$this->excel->getActiveSheet()->setCellValue('C45', 'Used Carbon Brush');
		$this->excel->getActiveSheet()->setCellValue('C46', 'Used Printer Toner');
		$this->excel->getActiveSheet()->setCellValue('C47', 'Used Paint');
		$this->excel->getActiveSheet()->setCellValue('A49', 'EXPORTED');
		$this->excel->getActiveSheet()->setCellValue('A51', 'OTHERS');
		$this->excel->getActiveSheet()->setCellValue('A53', 'TOTAL');
		$this->excel->getActiveSheet()->mergeCells('B53:E53');
		$this->excel->getActiveSheet()->setCellValue('A54', 'RESIDUE *');
		$this->excel->getActiveSheet()->mergeCells('B54:E54');
		$this->excel->getActiveSheet()->setCellValue('A55', 'NUMBER OF UNTREATED WASTE **');
		$this->excel->getActiveSheet()->mergeCells('B55:E55');
		$this->excel->getActiveSheet()->setCellValue('A56', 'TOTAL OF REMAIN WASTE');
		$this->excel->getActiveSheet()->mergeCells('B56:E56');
		$this->excel->getActiveSheet()->setCellValue('A57', 'Performance of Hazardous Waste Management During Permission Time Period');
		$this->excel->getActiveSheet()->mergeCells('B57:E57');

		$this->excel->getActiveSheet()->getStyle('A26:E57')->applyFromArray($styleArray);		
		unset($styleArray);

		$this->excel->getActiveSheet()->setCellValue('A59', 'NOTE');
		$this->excel->getActiveSheet()->mergeCells('A60:E60');
		$this->excel->getActiveSheet()->setCellValue('A60', '* Residue is a number of waste which generated from handling process such as incinerator, bottom ash, fly ash, sludge, oil reuse, residue of used oil storage and collection');
		$this->excel->getActiveSheet()->mergeCells('A61:E61');
		$this->excel->getActiveSheet()->setCellValue('A61', '** NUMBER OF UNTREATED WASTE is waste which is storage over permission time period');
		$this->excel->getActiveSheet()->mergeCells('A62:E62');
		$this->excel->getActiveSheet()->setCellValue('A62', 'All of data above is filled based on existing condition');

		$this->excel->getActiveSheet()->mergeCells('C63:E63');
		$this->excel->getActiveSheet()->setCellValue('C63', 'Knowledge by');
		$this->excel->getActiveSheet()->mergeCells('C64:E64');
		$this->excel->getActiveSheet()->setCellValue('C64', 'DEPUTY MANAGER of LK2');
		$this->excel->getActiveSheet()->mergeCells('C67:E67');
		$this->excel->getActiveSheet()->setCellValue('C67', 'JOKO PURWANTO');

		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename='Laporan_klh_'.date('Y-m-d').'.xlsx';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
	}

	function tanggals($id)
	{
		$bulan = array('JAN','FEB','MAR','APR','MEI','JUN','JUL','AUG','SEP','OKT','NOV','DES');
		$pecah = explode("-", $id);
		return $pecah[2]." ".$bulan[$pecah[1]-1]." ".$pecah[0];
	}
}