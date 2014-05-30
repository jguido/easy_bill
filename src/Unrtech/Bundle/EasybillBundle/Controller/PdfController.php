<?php

namespace Unrtech\Bundle\EasybillBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Unrtech\Bundle\EasybillBundle\Entity\BaseBill;
use Unrtech\Bundle\EasybillBundle\Entity\BillLine;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class PdfController extends Controller {

    /**
     * @Route("/bill/pdf/create/{bill}", name="path_bill_pdf_create")
     * @ParamConverter("bill", class="UnrtechEasybillBundle:BaseBill")
     */
    public function pdfBillCreateAction(Request $request, $bill) {
        $html = $this->render('UnrtechEasybillBundle:Bill:pdf_bill.html.twig', array(
            'bill' => $bill
        ));
//        return $this->render('UnrtechEasybillBundle:Bill:pdf_bill.html.twig', array(
//            'bill' => $bill
//        ));

        return new Response(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($html), 200, array(
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="file.pdf"'
                )
        );
    }

}
