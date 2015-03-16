<?php
	class code13
	{
		private $codeStr=array();//�ַ�����
		private $codeNum=array();//�ַ����뼯��
		private $chCodenum=array();//�������ַ���
		private $width;
		private $height;
		private $len;//��ô������鳤��
		private $str;//�����ַ�
		private $strs=array();//�����ַ�д�����飨����Ԫ��ƥ��ʱ��֧��string��
		private $img;//ͼƬ��Դ
		private $errorCh="";//������Ϣ
		function __construct($str="",$width=200,$height=60){//���캯��
			$this->setCodeStr();//�����ַ�����
			$this->width=$width;
			$this->height=$height;
			$this->str=$str;
			$this->len=strlen($this->str);//�����ַ�����
			$this->setStrs();//�������ַ�����������
			$this->setcodeNum();//������������
			if($this->checkCode()==false){
				$this->errorCh="�����ַ����ڷǷ��ַ���";
				continue;//�˳�
			}else{
				$this->outCodeStr();//-------------�����ַ���
			}
		}
		
		private function setCodeStr(){//�����ַ�����
			$codeStrs="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ-. $/+%*";//44�ַ�
			for($i=0;$i<44;$i++){//count�󲻵�$codeStrs����
				$this->codeStr[$i]=$codeStrs{$i};
			}
			
		}
		private function setStrs(){//�������ַ�����������
			for($i=0;$i<$this->len;$i++){
				$this->strs[$i]=$this->str{$i};
			}
		}
		private function checkCode(){//��֤�ַ����ĺ�����
			for($i=0;$i<$this->len;$i++){
				if(!in_array($this->strs[$i],$this->codeStr)){//??
					return false;
				}
			}
			return true;
		}
		private function outCodeStr(){//-------------�����ַ���
			if($this->checkCode()){//----------------����ַ���ͨ����֤
				$this->chCodenum{0}=$this->codeNum[43];//��ֵ��ʼ��
				$this->chCodenum{$this->len+1}=$this->codeNum[43];//��ֵ������
				for($i=0;$i<$this->len;$i++){
					$key=array_search($this->strs{$i},$this->codeStr);//�ҵ����ڼ�
					//echo $key."<br>";
					$this->chCodenum{$i+1}=$this->codeNum[$key];
				}
				return true;
			}else{
				$this->errorCh="�����ַ����ڷǷ��ַ���";
				return false;
			}
		}
		private function createCodeImg(){//����ͼƬ
			$width=($this->len+2)*12+$this->len+1;//ȡ�ó���
			$this->img=imagecreatetruecolor($width+20,$this->height);
			//$this->img=imagecreatetruecolor($this->width,$this->height);//����һ������(�Ƽ�)
			$bgcolor=imagecolorallocate($this->img,255,255,255);
			imagefill($this->img,0,0,$bgcolor);//�����ɫ
		}
		private function createCodeine(){//����������
			$black=imagecolorallocate($this->img,0,0,0);//��ɫ
			$white=imagecolorallocate($this->img,255,255,255);//��ɫ
			//imagettftext($this->img,8,0,10,$this->height-10,$black,"../fonts/DFPShaoNvW5-GB.ttf",$this->chCodenum{1});//����
			$x=0;
			for($i=0;$i<count($this->chCodenum);$i++){
				//imagettftext($this->img,5,0,$i*10+30,$this->height-15,$black,"../fonts/�����.ttf",$this->strs{$i});
				imagechar($this->img,5,$i*10+30,$this->height-15,$this->strs{$i},$black);
				for($j=0;$j<12;$j++)
				{	if($this->chCodenum{$i}{$j}==1)
						imagefilledrectangle($this->img,$i*12+$j+$x+10,5,$i*12+$j+$x+10,$this->height-20,$black);//���ľ���
				}
				$x++;
			}

		}
		private function outImg(){
			if(imagetypes() & IMG_GIF){//�жϷ�����֧���������
				header("Content-Type:image/gif");
				imagegif($this->img);
			}else if(imagetypes() &IMG_JPG){
				header("Content-Type:image/jpeg");
				imagegif($this->img);
			}else if(imagetypes() &IMG_PNG){
				header("Content-Type:image/png");
				imagegif($this->img);
			}else if(imagetypes() &IMG_WBMP){
				header("Content-Type:image/und.wap.wbmp");
				imagegif($this->img);
			}else{
				die("������̫�ɣ���֧�֣�");
			}
		}
		public function showCodeImage(){//���������ͼƬ		
			//return $this->chCodenum;
			$this->createCodeImg();//����ͼƬ
			$this->createCodeine();//����������
			$this->outImg();
		}
		private function setcodeNum(){//�����ַ������
			$this->codeNum[0]="101001101101";//0
			$this->codeNum[1]="110100101011";
			$this->codeNum[2]="101100101011";
			$this->codeNum[3]="110110010101";
			$this->codeNum[4]="101001101011";
			$this->codeNum[5]="110100110101";
			$this->codeNum[6]="101100110101";
			$this->codeNum[7]="101001011011";
			$this->codeNum[8]="110100101101";
			$this->codeNum[9]="101100101101";//9

			$this->codeNum[10]="110101001011";//A
			$this->codeNum[11]="101101001011";//B
			$this->codeNum[12]="110110100101";
			$this->codeNum[13]="101011001011";
			$this->codeNum[14]="110101100101";
			$this->codeNum[15]="101101100101";
			$this->codeNum[16]="101010011011";//
			$this->codeNum[17]="110101001101";
			$this->codeNum[18]="101101001101";
			$this->codeNum[19]="101011001101";
			$this->codeNum[20]="110101010011";//K

			$this->codeNum[21]="101101010011";//L
			$this->codeNum[22]="110110101001";
			$this->codeNum[23]="101011010011";
			$this->codeNum[24]="110101101001";
			$this->codeNum[25]="101101101001";
			$this->codeNum[26]="101010110011";
			$this->codeNum[27]="110101011001";
			$this->codeNum[28]="101101011001";
			$this->codeNum[29]="101011011001";
			$this->codeNum[30]="110010101011";//U

			$this->codeNum[31]="100110101011";//V
			$this->codeNum[32]="110011010101";
			$this->codeNum[33]="100101101011";
			$this->codeNum[34]="110010110101";
			$this->codeNum[35]="100110110101";//Z

			$this->codeNum[36]="100101011011";//-
			$this->codeNum[37]="110010101101";//.
			$this->codeNum[38]="100110101101";//�ո�
			$this->codeNum[39]="100100100101";//$
			$this->codeNum[40]="100100101001";///
			$this->codeNum[41]="100101001001";//+
			$this->codeNum[42]="101001001001";//%
			$this->codeNum[43]="100101101101";//*
		}
		function __destruct(){//��������
			imagedestroy($this->img);//�ͷ�ͼƬ��Դ
		}
	}
	
	
?>